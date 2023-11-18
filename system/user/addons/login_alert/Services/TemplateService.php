<?php

namespace Mithra62\LoginAlert\Services;

use Mithra62\LoginAlert\Exceptions\Services\TemplateServiceException;
use CI_DB_mysqli_result;
use Mithra62\LoginAlert\Traits\LoggerTrait;

class TemplateService
{
    use LoggerTrait;

    /**
     * @var int|null
     */
    protected ?int $site_id = 1;

    /**
     * @var string
     */
    protected string $custom_delim = '%';

    /**
     * @param ?int $site_id
     */
    public function __construct(int $site_id = null)
    {
        if($site_id) {
            $this->logger()->debug('Set site_id to: ' . $site_id);
            $this->site_id = $site_id;
        }

        if (!isset(ee()->TMPL)) {
            ee()->load->library('template', null, 'TMPL');
        }
    }

    /**
     * @return int
     */
    public function getSiteId(): ?int
    {
        return $this->site_id;
    }

    /**
     * @param int $site_id
     * @return $this
     */
    public function setSiteId(int $site_id): TemplateService
    {
        $this->logger()->debug('Set site_id to: ' . $site_id);
        $this->site_id = $site_id;
        return $this;
    }

    /**
     * @param string $template
     * @param array $vars
     * @param array $custom_vars
     * @return string
     * @throws TemplateServiceException
     */
    public function parseTemplate(string $template, array $vars = [], array $custom_vars = []): string
    {
        $template_data = $this->getTemplate($template);
        ee()->TMPL->parse_php = $template_data['allow_php'];
        ee()->TMPL->php_parse_location = $template_data['php_parse_location'];
        ee()->TMPL->template_type = ee()->functions->template_type = $template_data['template_type'];

        foreach ($custom_vars as $key => $value) {
            $template_data['template_data'] = str_replace($this->makeCustomVar($key), $value, $template_data['template_data']);
        }

        if ($vars) {
            $template_data['template_data'] = ee()->TMPL->parse_variables($template_data['template_data'], [$vars]);
        }

        ee()->TMPL->parse($template_data['template_data']);
        return ee()->TMPL->parse_globals(ee()->TMPL->final_template);;
    }

    /**
     * @param $str
     * @param array $vars
     * @return string
     */
    public function parseStr($str, array $vars = [], array $custom_vars = []): string
    {
        foreach ($custom_vars as $key => $value) {
            $str = str_replace($this->makeCustomVar($key), $value, $str);
        }

        return ee()->TMPL->parse_variables($str, [$vars]);;
    }

    /**
     * @param string $template_path
     * @return array|null
     * @throws TemplateServiceException
     */
    protected function getTemplate(string $template_path): ?array
    {
        $template = explode('/', $template_path);
        $template_group = $template[0] ?? null;
        $template_name = $template[1] ?? 'index';
        if (is_null($template_group)) {
            throw new TemplateServiceException("Cannot find group from your template path: " . $template_path);
        }

        $query = ee()->db->select('template_data, template_type, allow_php, php_parse_location, template_id')
            ->join('template_groups', 'templates.group_id = template_groups.group_id')
            ->where('group_name', $template_group)
            ->where('template_name', $template_name)
            ->where('templates.site_id', $this->getSiteId())
            ->get('templates');

        if ($query instanceof CI_DB_mysqli_result) {
            $template_data = $query->row_array();
            if (PATH_TMPL && ee()->config->item('save_tmpl_files') === 'y') {
                $template_data['template_data'] = $this->getTemplateFileData($template_group, $template_name, $template_data['template_type']);
            }

            $template_data['template_data'] = str_replace(["\r\n", "\r"], "\n", $template_data['template_data']);

            ee()->TMPL->group_name = $template_group;
            ee()->TMPL->template_name = $template_name;
            ee()->TMPL->template_id = $template_data['template_id'];
            ee()->TMPL->template_type = $template_data['template_type'];

            return $template_data;
        }

        $this->logger()->debug('Email template not found ' . $template_path);
        return null;
    }

    /**
     * @param $template_group
     * @param $template_name
     * @param $template_type
     * @return string|null
     */
    protected function getTemplateFileData($template_group, $template_name, $template_type): ?string
    {
        ee()->load->library('api');
        ee()->legacy_api->instantiate('template_structure');
        $file = PATH_TMPL . $this->getSiteShortname() . '/'
            . $template_group . '.group/' . $template_name
            . ee()->api_template_structure->file_extensions($template_type);

        if (file_exists($file)) {
            return file_get_contents($file);
        }

        $this->logger()->debug('Email template file not found ' . $template_group . '/' . $template_name);
        return null;
    }

    /**
     * @return string
     */
    protected function getSiteShortname(): string
    {
        $return = ee()->config->item('site_short_name');
        if ($this->getSiteId()) {
            $query = ee()->db->select('site_name')
                ->from('sites')
                ->where(['site_id' => $this->getSiteId()])
                ->limit(1)
                ->get();
            if($query instanceof CI_DB_mysqli_result) {
                $return = $query->row('site_name');
            }
        }

        return $return;
    }

    /**
     * @param string $delim
     * @return $this
     */
    public function setCustomDelim(string $delim): TemplateService
    {
        $this->custom_delim = $delim;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomDelim(): string
    {
        return $this->custom_delim;
    }

    /**
     * @param $var
     * @return string
     */
    public function makeCustomVar($var): string
    {
        return $this->getCustomDelim() . $var . $this->getCustomDelim();
    }
}