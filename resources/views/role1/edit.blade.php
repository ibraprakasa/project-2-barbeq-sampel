@extends('layouts.app')

@section('title','Roles')
@section('content_header_title','Roles')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Admin</h3>
            <div class="box-tools">

            </div>
        </div>
        <div class="box-body table-responsive">
            <form action="" id="form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="employeeFirstName">Name<span class="text-red">*</span></label>
                    <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                </div>
                <div class="form-group">
                    <label for="employeeFirstName">Description</label>
                    <input type="text" class="form-control" name="description" value="{{ $data->description }}">
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Menu</th>
                        <th width="10%">View</th>
                        <th width="10%">Add</th>
                        <th width="10%">Edit</th>
                        <th width="10%">Delete</th>
                        <th width="10%">Other</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menuItems as $menuItem)
                        @php
                            $view = $add = $edit = $delete = $other = 0;
                        @endphp
                        @foreach ($data->privileges as $item)
                            @if ($menuItem['id'] == $item->menu_item_id)
                                @php
                                    $view = $item->view;
                                    $add = $item->add;
                                    $edit = $item->edit;
                                    $delete = $item->delete;
                                    $other = $item->other;
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <td>{{ $menuItem['menu_group']['name'] }}/{{ $menuItem['name'] }}</td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem['id'] }}][view]" value="1"
                                        {{ $view == 1?'checked':'' }}>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem['id'] }}][add]" value="1"
                                        {{ $add == 1?'checked':'' }}>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem['id'] }}][edit]" value="1"
                                        {{ $edit == 1?'checked':'' }}>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem['id'] }}][delete]" value="1"
                                        {{ $delete == 1?'checked':'' }}>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="" name="menu[{{ $menuItem['id'] }}][other]" value="1"
                                        {{ $other == 1?'checked':'' }}>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button class="btn btn-default" onclick="history.back()">Back</button>
                <button class="btn btn-primary" form="form">Save</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
