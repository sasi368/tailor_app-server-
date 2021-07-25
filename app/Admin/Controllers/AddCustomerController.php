<?php

namespace App\Admin\Controllers;

use App\Models\AddCustomer;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AddCustomerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'AddCustomer';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AddCustomer());

        $grid->column('id', __('Id'));
        $grid->column('customer_code', __('Customer Code'));
        $grid->column('customer_name', __('Customer name'));
        $grid->column('branch', __('Branch name'));
        $grid->column('gender', __('Gender'));
        $grid->column('email', __('Email'));
        $grid->column('contact_no', __('Contact no'));
        $grid->column('address', __('Address'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableExport();
        $grid->actions(function ($actions) {
        $actions->disableView();
        });

        $grid->filter(function ($filter) {
            
         $filter->like ('customer_code', 'Customer Code');
         $filter->like ('customer_name', 'Customer name');
         $filter->like ('branch', 'Branch name');
         $filter->like ('gender', 'gender');
         $filter->like ('contact_no', 'Contact no');
         $filter->like ('email', 'Email');
         $filter->like ('address', 'Address');
            
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
        $show = new Show(AddCustomer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('customer_code', __('Customer Code'));
        $show->field('customer_name', __('Customer name'));
        $show->field('branch', __('Branch name'));
        $show->field('gender', __('Gender'));
        $show->field('email', __('Email'));
        $show->field('contact_no', __('Contact no'));
        $show->field('address', __('Address'));
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
        $form = new Form(new AddCustomer());

        $form->text('customer_name', __('Customer name'))->rules('required|max:250');
         $form->text('customer_code', __('Customer code'))->rules('required|digits:4|numeric');
         $form->text('branch', __('Branch Name'))->rules('required|max:250');
        $form->text('gender', __('Gender'))->rules('required|max:250');
        $form->email('email', __('Email'))->rules('required|email|unique:users,email');
        $form->text('contact_no', __('Contact no'))->rules('required|numeric');
        $form->textarea('address', __('Address'))->rules('required|max:250');


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
