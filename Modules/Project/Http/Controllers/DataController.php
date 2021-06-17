<?php

namespace Modules\Project\Http\Controllers;

use App\User;
use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Menu;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectTask;
use Modules\Project\Entities\ProjectTransaction;
use Modules\Project\Utils\ProjectUtil;

class DataController extends Controller
{

    /**
     * Parses notification message from database.
     * @return array
     */
    public function parse_notification($notification)
    {
        $notification_datas = [];
        if ($notification->type == 'Modules\Project\Notifications\NewProjectAssignedNotification') {
            $data = $notification->data;
            $project = Project::with('createdBy')
                            ->find($data['project_id']);

            if (!empty($project)) {
                $msg = __(
                    'project::lang.new_project_assgined_notification',
                    [
                    'created_by' => $project->createdBy->user_full_name,
                    'project' => $project->name
                    ]
                );

                $link = action('\Modules\Project\Http\Controllers\ProjectController@show', ['id' => $project->id]);

                $notification_datas = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa fa-check-circle bg-green',
                    'link' => $link,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        } elseif ($notification->type == 'Modules\Project\Notifications\NewTaskAssignedNotification') {
            $data = $notification->data;
            $task = ProjectTask::with('createdBy')
                        ->where('project_id', $data['project_id'])
                        ->find($data['project_task_id']);

            if (!empty($task)) {
                $msg = __(
                    'project::lang.new_task_assgined_notification',
                    [
                    'created_by' => $task->createdBy->user_full_name,
                    'subject' => $task->subject,
                    'task_id' => $task->task_id
                    ]
                );

                $link = action('\Modules\Project\Http\Controllers\ProjectController@show', ['id' => $task->project_id]);

                $notification_datas = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-tasks bg-green',
                    'link' => $link,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        } elseif ($notification->type == 'Modules\Project\Notifications\NewCommentOnTaskNotification') {
            $data = $notification->data;
            $task = ProjectTask::with('createdBy')
                        ->where('project_id', $data['project_id'])
                        ->find($data['project_task_id']);

            if (!empty($task)) {
                $user = User::find($data['commented_by']);
            
                $msg = __(
                    'project::lang.new_comment_on_task_notification',
                    [
                    'commented_by' => $user->user_full_name,
                    'subject' => $task->subject,
                    'task_id' => $task->task_id
                    ]
                );

                $link = action('\Modules\Project\Http\Controllers\ProjectController@show', ['id' => $task->project_id]);

                $notification_datas = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-comment-dots bg-green',
                    'link' => $link,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        }

        return $notification_datas;
    }

    /**
     * Adds Project menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        $business_id = session()->get('user.business_id');
        $module_util = new ModuleUtil();
        $commonUtil = new Util();
        $is_admin = $commonUtil->is_admin(auth()->user(), $business_id);
        
        if (auth()->user()->can('superadmin')) {
            $is_project_enabled = $module_util->isModuleInstalled('Project');
        } else {
            $is_project_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'project_module');
        }

        if ($is_project_enabled) {
            Menu::modify(
                'admin-sidebar-menu',
                function ($menu) use ($is_admin) {
                    $menu->dropdown(
                        __('project::lang.project'),
                        function ($sub) use ($is_admin) {
                            $sub->url(
                                action('\Modules\Project\Http\Controllers\ProjectController@index') . '?project_view=list_view',
                                __('project::lang.projects'),
                                ['icon' => 'fa fas fa-check-circle', 'active' => request()->segment(2) == 'project']
                             );

                            $sub->url(
                                action('\Modules\Project\Http\Controllers\TaskController@index'),
                                __('project::lang.my_tasks'),
                                ['icon' => 'fa fa-tasks', 'active' => request()->segment(2) == 'project-task']
                            );

                            if ($is_admin) {
                                $sub->url(action('\Modules\Project\Http\Controllers\ReportController@index'), __('report.reports'), ['icon' => 'fa fas fa-chart-bar', 'active' => request()->segment(2) == 'project-reports']);
                            }

                            if ($is_admin) {
                                $sub->url(
                                    action('TaxonomyController@index') . '?type=project',
                                    __('project::lang.project_categories'),
                                    ['icon' => 'fa fas fa-gem', 'active' => request()->get('type') == 'project']
                                );
                            }
                        },
                        ['icon' => 'fa fa-check-square'
                ]
            )->order(86);
                }
            );
        }
    }

    /**
     * get gross project from
     * project
     * @param $business_id, $start_date, $end_date,
     *  $location_id
     * @return decimal
     */
    public function grossProfit($params)
    {
        $transaction = ProjectTransaction::where('business_id', $params['business_id'])
            ->where('type', 'sell')
            ->where('sub_type', 'project_invoice')
            ->where('status', 'final');

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            if ($params['start_date'] == $params['end_date']) {
                $transaction->whereDate('transaction_date', $params['end_date']);
            } else {
                $transaction->whereBetween(DB::raw('transaction_date'), [$params['start_date'], $params['end_date']]);
            }
        }

        $transaction = $transaction->select(DB::raw('SUM(final_total) as gross_profit'))
            ->first();

        return $transaction;
    }

    /**
     * Defines user permissions for the module.
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'project.create_project',
                'label' => __('project::lang.create_project'),
                'default' => false
            ],
            [
                'value' => 'project.edit_project',
                'label' => __('project::lang.edit_project'),
                'default' => false
            ],
            [
                'value' => 'project.delete_project',
                'label' => __('project::lang.delete_project'),
                'default' => false
            ],
        ];
    }

    /**
     * Superadmin package permissions
     * @return array
     */
    public function superadmin_package()
    {
        return [
            [
                'name' => 'project_module',
                'label' => __('project::lang.project_module'),
                'default' => false
            ]
        ];
    }

    /**
    * Function to return Project module
    * permission for doc & note if notable type
    * and notable id validates
    * @return array
    */
    public function addDocumentAndNotes($params)
    {
        $permissions = [];

        $notable_type = $params['notable_type'];
        if ($notable_type == 'Modules\Project\Entities\Project') {
            $notable = $notable_type::where('business_id', $params['business_id'])
                ->find($params['notable_id']);

            if (!empty($notable)) {
                //check if user is member/lead/admin
                $commonUtil = new Util();
                $projectUtil = new ProjectUtil();
                $is_admin = $commonUtil->is_admin(auth()->user(), $params['business_id']);
                $is_lead = $projectUtil->isProjectLead(auth()->user()->id, $params['notable_id']);
                $is_member = $projectUtil->isProjectMember(auth()->user()->id, $params['notable_id']);

                //user is member/lead/admin;assign permission
                if (($is_admin || $is_lead)) {
                    $permissions = ['view', 'create', 'delete'];
                } elseif ($is_member) {
                    if (isset($notable->settings['members_crud_note']) && $notable->settings['members_crud_note']) {
                        $permissions = ['view', 'create', 'delete'];
                    } else {
                        $permissions = ['view'];
                    }
                }
            }
        }

        return [
            'Modules\Project\Entities\Project' => [
                'permissions' => $permissions
            ]
        ];
    }

    /**
    * Function to add essential module taxonomies
    * @return array
    */
    public function addTaxonomies()
    {
        $business_id = request()->session()->get('user.business_id');

        $module_util = new ModuleUtil();
        if (!(auth()->user()->can('superadmin') || $module_util->hasThePermissionInSubscription($business_id, 'project_module'))) {
            return ['project' => []];
        }

        return [
            'project' => [
                'taxonomy_label' =>  __('project::lang.project_category'),
                'heading' => __('project::lang.project_categories'),
                'sub_heading' => __('project::lang.manage_project_categories'),
                'enable_taxonomy_code' => false,
                'enable_sub_taxonomy' => false
            ]
        ];
    }
}
