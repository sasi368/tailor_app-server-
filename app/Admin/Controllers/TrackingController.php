<?php

namespace App\Admin\Controllers;

use App\Models\Tracking;
use App\Models\AddCustomer;
use App\Models\Service;
use App\Models\Login;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TrackingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Tracking';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tracking());

        $grid->column('id', __('Id'));
        $grid->column('order_id', __('Order Id'));
        $grid->column('customer_name', __('Customer name'))->display(function($add_customers){
            $customer_name = AddCustomer::where('customer_name',$add_customers)->value('customer_name');
                return "$customer_name";
        });
        $grid->column('service_name', __('Service name'))->display(function($services){
            $service_name = Service::where('service_name',$services)->value('service_name');
                return "$service_name";
        });
        $grid->column('employee_name', __('Employee name'))->display(function($logins){
            $user_name = Login::where('user_name',$logins)->value('user_name');
                return "$user_name";
        });
        $grid->column('position', __('Position'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableExport();
        $grid->actions(function ($actions) {
        $actions->disableView();
        });

        $grid->filter(function ($filter) {

        $add_customers = AddCustomer::pluck('customer_name', 'customer_name');
        $services = Service::pluck('service_name', 'service_name');
        $logins = Login::pluck('user_name', 'user_name');

   
         $filter->equal ('customer_name', 'Service name')->select($add_customers);
         $filter->equal ('service_name', 'Service name')->select($services);
         $filter->equal ('employee_name', 'Employee name')->select($logins);
         $filter->like ('position', 'Position');
        
        
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Tracking::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_id', __('Order Id'));
        $show->field('customer_name', __('customer_name'));
        $show->field('service_name', __('Service name'));
        $show->field('employee_name', __('Employee name'));
        $show->field('position', __('Position'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }
 
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Tracking);
        
        $add_customers = AddCustomer::pluck('customer_name', 'customer_name');
        $services = Service::pluck('service_name', 'service_name');
        $logins = Login::pluck('user_name', 'user_name');
        
        $form->text('order_id', __('Order Id'))->rules('required|max:250');
        $form->select('customer_name', __('Customer name'))->options($add_customers)->rules('required');
        $form->select('service_name', __('Service name'))->options($services)->rules('required');
        $form->select('employee_name', __('Employee name'))->options($logins)->rules('required');
        $form->text('position', __('Position'))->rules('required|max:250');


           $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete(); 
            $tools->disableView();
        });
           $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}
