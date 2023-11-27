<?php

namespace Mithra62\LoginAlert\ControlPanel\Routes;

use ExpressionEngine\Library\CP\Table;
use ExpressionEngine\Service\Addon\Controllers\Mcp\AbstractRoute;
use Mithra62\LoginAlert\Model\MemberLoginAlert as Settings;

class Index extends AbstractRoute
{
    protected $addon_name = 'login_alert';

    /**
     * @var string
     */
    protected $route_path = 'index';

    /**
     * @var string
     */
    protected $cp_page_title = 'Index';

    /**
     * @var string
     */
    protected $base_url = 'addons/settings/login_alert';

    /**
     * @param false $id
     * @return AbstractRoute
     */
    public function process($id = false)
    {
        $sort_col = ee('Request')->get('sort_col') ?: 'la.id';
        $sort_dir = ee('Request')->get('sort_dir') ?: 'desc';
        $this->per_page = ee('Request')->get('perpage') ?: $this->per_page;

        $query = [
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
        ];

        $base_url = ee('CP/URL')->make($this->base_url . '/index', $query);
        $table = ee('CP/Table', [
            'lang_cols' => true,
            'sort_col' => $sort_col,
            'sort_dir' => $sort_dir,
            'class' => 'role_expire',
            'limit' => $this->per_page,
        ]);

        $vars['cp_page_title'] = lang('la.title');
        $table->setColumns([
            'la.id' => 'id',
            'la.name' => 'name',
            'la.type' => ['sort' => false],
            'la.status' => ['encode' => false, 'sort' => false],
            'la.manage' => [
                'type' => Table::COL_TOOLBAR,
            ],
        ]);

        $table->setNoResultsText(sprintf(lang('no_found'), lang('la.alerts')));

        $alerts = ee('Model')
            ->get('login_alert:Settings')
            ->filter('site_id', ee()->config->item('site_id'));

        $page = ((int)ee('Request')->get('page')) ?: 1;
        $offset = ($page - 1) * $this->per_page; // Offset is 0 indexed

        // Handle Pagination
        $totalAlerts = $alerts->count();

        $alerts->limit($this->per_page)
            ->offset($offset);

        $data = [];
        $sort_map = [
            'la.id' => 'id',
            'la.name' => 'name',
        ];

        $alerts->order($sort_map[$sort_col], $sort_dir);
        foreach ($alerts->all() as $alert) {
            $url = $this->url( 'edit/' . $alert->getId());
            $data[] = [
                [
                    'content' => $alert->getId(),
                    'href' => $url,
                ],
                $alert->name,
                $alert->log_into,
                "<span class='" . $this->getStatusCss($alert) . "'>" . lang($this->getEnabled($alert)) . '</span>',
                ['toolbar_items' => [
                    'edit' => [
                        'href' => $url,
                        'title' => lang('la.edit_alert'),
                    ],
                    'remove' => [
                        'href' => $this->url( 'delete/' . $alert->getId()),
                        'title' => lang('la.remove_alert'),
                    ],
                ]],
            ];
        }

        $table->setData($data);

        $vars['pagination'] = ee('CP/Pagination', $totalAlerts)
            ->perPage($this->per_page)
            ->currentPage($page)
            ->render($base_url);
        $vars['table'] = $table->viewData($base_url);
        $vars['base_url'] = $base_url;

        $this->setBody('index', $vars);
        return $this;
    }

    /**
     * @param Settings $alert
     * @return string
     */
    public function getStatusCss(Settings $alert): string
    {
        $status_class = 'st-pending';
        if ($alert->status === 1) {
            $status_class = 'st-open';
        }

        return $status_class;
    }

    /**
     * @param Settings $alert
     * @return string
     */
    public function getEnabled(Settings $alert): string
    {
        if($alert->status === 1) {
            return lang('la.enabled');
        }

        return lang('la.disabled');
    }
}
