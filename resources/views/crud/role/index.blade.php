@extends('templates.crud.index', ['datas'=>$datas, 'columns'=>$columns, 'routeName'=>'role'])

@section('title', 'Roles')
@section('description', 'Create a Role data first before assign to user')