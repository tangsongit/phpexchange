<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\User\PassUserAuth;
use App\Admin\Actions\User\RejectUserAuth;
use App\Models\UserAuth;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserAuthController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new UserAuth(), function (Grid $grid) {
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableQuickEdit();
                $actions->disableEdit();
                $actions->disableView();
            });

            $grid->disableCreateButton();
            $grid->disableDeleteButton();
            $grid->disableEditButton();

            $grid->tools([
                new PassUserAuth(),
                new RejectUserAuth(),
            ]);

            $grid->toolsWithOutline(false);


            $grid->id->sortable();
            $grid->user_id;
            $grid->realname;
            $grid->country_code;
            $grid->id_card;
            $grid->front_img->image('', 50, 50);
            $grid->back_img->image('', 50, 50);
            $grid->hand_img->image('', 50, 50);
            $grid->check_time;
            $grid->primary_status->using(UserAuth::$primaryStatusMap)->dot([0 => 'default', 1 => 'success']);
            $grid->status->using(UserAuth::$statusMap)->dot([0 => 'default', 1 => 'danger', 2 => 'success', 3 => 'primary']);
            $grid->created_at->sortable();
            //            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new UserAuth(), function (Show $show) {
            $show->id;
            $show->user_id;
            $show->realname;
            $show->country_code;
            $show->id_card;
            $show->front_img;
            $show->back_img;
            $show->hand_img;
            $show->check_time;
            $show->status;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new UserAuth(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('realname');
            $form->text('country_code');
            $form->text('id_card');
            $form->text('front_img');
            $form->text('back_img');
            $form->text('hand_img');
            $form->text('check_time');
            $form->text('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
