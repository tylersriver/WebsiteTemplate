<?php


class LoginView extends AbstractView
{
    function __construct()
    {
        $this->html =

        h('div.container',
            h('div.row',
                h('div.baseContainer.col-8.offset-2',
                    h('h2', 'Login'),
                    h('form.form-horizontal', ['action' => '?controller=user&action=login', 'method' => 'POST'],
                        h('div.form-group.row',
                            h('label.col-sm-2.col-form-label.col-form-label-sm', 'Username'),
                            h('div.col-sm-10',
                                h('input.form-control.form-control-sm', [
                                    'type' => 'text',
                                    'name' => 'username',
                                    'id'=>'username',
                                    'placeholder'=>'Username'
                                ])
                            )
                        ),
                        h('div.form-group.row',
                            h('label.col-sm-2.col-form-label.col-form-label-sm', 'Password'),
                            h('div.col-sm-10',
                                h('input.form-control.form-control-sm', [
                                    'type' => 'text',
                                    'name' => 'password',
                                    'id'=>'password',
                                    'placeholder'=>'Password'
                                ])
                            )
                        ),
                        h('button.btn.btn-primary', ['type'=>'submit'], 'Login'),
                        h('span', ['style' => 'color: red'], $_GET['error']),
                        h('br')
                    )
                )
            )
        );
    }
}