<?php

namespace App\Admin\Controllers;

use App\Models\Measurement;
use Encore\Admin\Controllers\AdminController;
use App\Models\AddCustomer;
use App\Models\Service;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MeasurementController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Measurement';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Measurement());

        $grid->column('id', __('Id'));
        $grid->column('customer_code', __('Customer Code'))->display(function($add_customers_code){
            $customer_code= AddCustomer::where('customer_code',$add_customers_code)->value('customer_code');
                return "$customer_code";
        });
         $grid->column('customer_name', __('Customer name'))->display(function($add_customers){
            $customer_name = AddCustomer::where('customer_name',$add_customers)->value('customer_name');
                return "$customer_name";
        });
         $grid->column('service_name', __('Service name'))->display(function($services){
            $service_name = Service::where('service_name',$services)->value('service_name');
                return "$service_name";
        });
        $grid->column('service_price', __('Service price'));
        $grid->column('shirt_length', __('Shirt length'));
        $grid->column('arm_length', __('Arm length'));
        $grid->column('shoulder', __('Shoulder'));
        $grid->column('front_neck', __('Front neck'));
        $grid->column('back_neck', __('Back neck'));
        $grid->column('chest', __('Chest'));
        $grid->column('arm_hole', __('Arm hole'));
        $grid->column('cuff', __('Cuff'));
        $grid->column('hip', __('Hip'));
        $grid->column('pant', __('Pant'));
        $grid->column('seat', __('Seat'));
        $grid->column('paincha', __('Paincha'));
        $grid->column('branch', __('Branch'));
        $grid->column('position', __('Position'));
        $grid->column('taken_on', __('Taken on'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableExport();
        $grid->actions(function ($actions) {
        $actions->disableView();
        });

        $grid->filter(function ($filter) {

        $add_customers_code = AddCustomer::pluck('customer_code', 'customer_code');
        $add_customers = AddCustomer::pluck('customer_name', 'customer_name');
        $services = Service::pluck('service_name', 'service_name');

   
         $filter->equal ('customer_name', 'Service name')->select($add_customers);
         $filter->equal ('service_name', 'Service name')->select($services);
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
        $show = new Show(Measurement::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('customer_code', __('Customer Code'));
        $show->field('customer_name', __('Customer name'));
        $show->field('service_name', __('Service name'));
        $show->field('service_price', __('Service price'));
        $show->field('shirt_length', __('Shirt length'));
        $show->field('arm_length', __('Arm length'));
        $show->field('shoulder', __('Shoulder'));
        $show->field('front_neck', __('Front neck'));
        $show->field('back_neck', __('Back neck'));
        $show->field('chest', __('Chest'));
        $show->field('arm_hole', __('Arm hole'));
        $show->field('cuff', __('Cuff'));
        $show->field('hip', __('Hip'));
        $show->field('pant', __('Pant'));
        $show->field('seat', __('Seat'));
        $show->field('paincha', __('Paincha'));
        $show->field('branch', __('Branch'));
        $show->field('position', __('Position'));
        $show->field('taken_on', __('Taken on'));
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
        $form = new Form(new Measurement());

        $add_customers_code = AddCustomer::pluck('customer_code', 'customer_code');
        $add_customers = AddCustomer::pluck('customer_name', 'customer_name');
        $services = Service::pluck('service_name', 'service_name');

        $form->select('customer_code', __('Customer Code'))->options($add_customers_code)->rules('required');
        $form->select('customer_name', __('Customer name'))->options($add_customers)->rules('required');
        $form->select('service_name', __('Service name'))->options($services)->rules('required');
        $form->text('service_price', __('Service price'))->rules('required');
        $form->text('shirt_length', __('Shirt length'));
        $form->text('arm_length', __('Arm length'));
        $form->text('shoulder', __('Shoulder'));
        $form->text('front_neck', __('Front neck'));
        $form->text('back_neck', __('Back neck'));
        $form->text('chest', __('Chest'));
        $form->text('arm_hole', __('Arm hole'));
        $form->text('cuff', __('Cuff'));
        $form->text('hip', __('Hip'));
        $form->text('pant', __('Pant'));
        $form->text('seat', __('Seat'));
        $form->text('paincha', __('Paincha'));
        $form->text('branch', __('Branch'))->rules('required');
        $form->number('position', __('Position'))->rules('required|max:250')->rules('required');
        $form->date('taken_on', __('Taken on'))->default(date('Y-m-d'))->rules('required');

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
