@extends('templates.crud.index', ['datas' => $datas, 'columns' => $columns, 'routeName' => 'user'])

@section('title', 'Users')
@section('description', 'Manage Users first and then assign role to it')
