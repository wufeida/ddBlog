<?php

namespace App\Console\Commands;

use App\Model\User;
use Validator;
use RuntimeException;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建一个管理员';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('用户名?');
        $password = $this->secret('密码?(最少六位)');

        $data = [
            'name'     => $name,
            'password' => $password,
        ];

        if ( $this->register($data) ) {
            $this->info('创建成功');
        } else {
            $this->error('创建出现问题');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function register($data)
    {
        $message = [
            'name.required' => "用户名不能为空",
            'name.unique' => "用户名已存在",
            'name.max' => "用户名最大255位",
            'password.required' => "密码必填",
            'password.min' => "密码最少6位",
        ];
        $validator = Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'password' => 'required|min:6',
        ],$message);

        if (!$validator->passes()) {
            throw new RuntimeException($validator->errors()->first());
        }

        return $this->create($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create($data)
    {
        return User::create([
            'name'     => $data['name'],
            'status'   => true,
            'is_admin' => true,
            'password' => bcrypt($data['password']),
        ]);
    }
}
