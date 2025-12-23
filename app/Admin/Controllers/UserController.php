<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    protected $title = 'User';

    /**
     * グリッド一覧
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('nickname', __('Nickname'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();
        $grid->column('deleted_at', __('Deleted at'))->sortable();

        $grid->filter(function($filter) {
            $filter->like('name', 'ユーザー名');
            $filter->like('nickname', 'ニックネーム');
            $filter->like('email', 'メールアドレス');
            $filter->between('created_at', '登録日')->datetime();
            $filter->scope('trashed', '退会済み')->onlyTrashed();
        });

        return $grid;
    }

    /**
     * 詳細表示
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('nickname', __('Nickname'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * フォーム
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'))->required();
        $form->text('nickname', __('Nickname'));
        $form->email('email', __('Email'))->required();
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        
        // パスワードを保存する前にハッシュ化
        $form->saving(function (Form $form) {
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
            }
        });

        // 削除ボタンを押したときは forceDelete に変更
        $form->deleting(function (Form $form) {
            $form->model()->forceDelete();
        });

        // deleted_at はフォームに表示しない（管理用だけ）
        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete(); // 標準の削除は無効化
        });

        return $form;
    }
}
