<?php

namespace AsayDev\LaraTickets\Livewire;

use AsayDev\LaraTickets\Models\Agent;
use Livewire\Component;
use Livewire\WithPagination;

class LaraTicketsDashboard extends Component
{
    use WithPagination;


    public $dashboardData = [];

    protected $listeners = ['setActiveNavTab', 'activeNvTab', 'setActionForm', 'openForm'];


    public function mount($model = '', $modelId = null, $options = [], $ownerId = null)
    {
        if (!$ownerId) {
            $ownerId = auth()->user()->id;
        }
        $this->dashboardData = array(
            'model' => $model,
            'model_id' => $modelId,
            'options' => $options,
            'user_id' => $ownerId
        );
        $user = Agent::find($ownerId);
        if ($this->dashboardData['model'] == 'general') {
            if ($user && $user->laratickets_isAdmin()) {
                $this->dashboardData['usertype'] = 'admin';
                $this->dashboardData['active_nav_tab'] = 'main-tab';
            } else {
                $this->dashboardData['usertype'] = 'agent';
                $this->dashboardData['active_nav_tab'] = 'active-tickets-tab';
            }
        } else {
            $this->dashboardData['usertype'] = 'agent';
            $this->dashboardData['active_nav_tab'] = 'active-tickets-tab';
        }
        $this->setActiveNavTab($this->dashboardData['active_nav_tab']);
    }

    public function render()
    {
        return view('asaydev-lara-tickets::dashboard');
    }


    public function setActiveNavTab($active_nav_tab)
    {
        $this->dashboardData['active_nav_tab'] = $active_nav_tab;
        if (!isset($dashboardData['form'])) {
            $this->dashboardData['form'] = ['name' => '', 'action' => ''];
        }
        if ($this->dashboardData['active_nav_tab'] == 'active-tickets-tab' || $this->dashboardData['active_nav_tab'] == 'completed-tickets-tab') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::lang.index-my-tickets');
        } else if ($this->dashboardData['active_nav_tab'] == 'admin-tab') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.administrator-index-title');
        } else if ($this->dashboardData['active_nav_tab'] == 'config-tab') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.nav-configuration');
        } else if ($this->dashboardData['active_nav_tab'] == 'category-tab') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.category-index-title');
        } else if ($this->dashboardData['active_nav_tab'] == 'agents-tab') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.agent-index-title');
        } else if ($this->dashboardData['active_nav_tab'] == 'priorities-tab') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.priority-index-title');
        } else if ($this->dashboardData['active_nav_tab'] == 'statuses-tab') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.status-index-title');
        } else if ($this->dashboardData['active_nav_tab'] == 'waitingClientReply-tickets-tab') {
            $this->dashboardData['active_nav_title'] = trans('Waiting client reply');
        } else if ($this->dashboardData['active_nav_tab'] == 'waitingManagingReply-tickets-tab') {
            $this->dashboardData['active_nav_title'] = trans('Waiting managing reply');
        }
        // refresh tickets table data
        $this->emit('setDashboardData', $this->dashboardData);
    }

    public function openForm($form_name)
    {
        if ($form_name == 'new_ticket') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::lang.index-my-tickets') . ': ' . trans('laratickets::lang.create-new-ticket');
            $this->setActionForm(['name' => 'tickets', 'action' => 'add']);
        } else if ($form_name == 'new_admin') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.administrator-index-title') . ': ' . trans('laratickets::admin.btn-create-new-administrator');
            $this->setActionForm(['name' => 'admins', 'action' => 'add']);
        } else if ($form_name == 'new_configuration') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.nav-configuration') . ': ' . trans('laratickets::admin.config-create-title');
            $this->setActionForm(['name' => 'configuration', 'action' => 'add']);
        } else if ($form_name == 'new_category') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.category-index-title') . ': ' . trans('laratickets::admin.btn-create-new-category');
            $this->setActionForm(['name' => 'categories', 'action' => 'add']);
        } else if ($form_name == 'new_agent') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.agent-index-title') . ': ' . trans('laratickets::admin.btn-create-new-agent');
            $this->setActionForm(['name' => 'agents', 'action' => 'add']);
        } else if ($form_name == 'new_priority') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.priority-index-title') . ': ' . trans('laratickets::admin.btn-create-new-priority');
            $this->setActionForm(['name' => 'priorities', 'action' => 'add']);
        } else if ($form_name == 'new_status') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.status-index-title') . ': ' . trans('laratickets::admin.btn-create-new-status');
            $this->setActionForm(['name' => 'statuses', 'action' => 'add']);
        } else if ($form_name == 'ticket-replies') {
            $this->dashboardData['active_nav_title'] = trans('laratickets::admin.nav-ticket-replies') . ': ' . trans('laratickets::admin.config-create-title');
            $this->setActionForm(['name' => 'configuration', 'action' => 'add']);
        }
    }

    public function activeNvTab($dashboardData)
    {

        $this->dashboardData = $dashboardData;
        // close opened form
    }

    public function setActionForm($form)
    {
        $this->dashboardData['form'] = $form;
        $this->emit('setDashboardData', $this->dashboardData);
    }
}
