@extends('layouts.dashboard')

@section('content')
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">

            <!--overview start-->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-home"></i><a href="/dashboard/home">Home</a></li>
                        <li><i class="fa fa-users"></i>Users</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2><i class="fa fa-flag-o red"></i><strong>Registered Users</strong></h2>
                            <div class="panel-actions">
                                <a href="/dashboard/home" class="btn-setting"><i class="fa fa-rotate-right"></i></a>
                                <a href="/dashboard/home" class="btn-minimize"><i class="fa fa-chevron-up"></i></a>
                                <a href="/dashboard/home" class="btn-close"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table bootstrap-datatable countries">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Subscription</th>
                                        <th>Main role</th>
                                        <th>Ban from store ban</th>
                                        <th>View</th>
                                        <th>Edit</th>
                                        <th>Delete</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users) > 0)
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    {{ optional($user->subscription)->name ?? 'No active Subscription' }}

                                                    <form action="{{ route('admin.users.update-subscription', $user) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')

                                                        <div class="form-group">
                                                            <label for="subscription_id">Select Subscription</label>
                                                            <select name="subscription_id" id="subscription_id"
                                                                class="form-control">
                                                                @foreach ($subscriptions as $subscription)
                                                                    <option value="{{ $subscription->id }}"
                                                                        {{ $user->subscription_id == $subscription->id ? 'selected' : '' }}>
                                                                        {{ $subscription->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary">Update
                                                            Subscription</button>
                                                    </form>
                                                </td>
                                                <td>{{ optional($user->role)->name }}</td>
                                                <td>
                                                    <div>
                                                        <div>
                                                            @if ($user->banned_until >= 1 || $user->is_permbanned === 1)
                                                                <form method="POST" class="flex flex-col"
                                                                    action="{{ route('forum.unban', ['userId' => $user->id]) }}">
                                                                    @csrf
                                                                    @method('GET')
                                                                    <input type="hidden" name="context" value="unbanForum">
                                                                    <button class="rounded-md forum-unban-button"
                                                                        style="background-color: rgb(161, 92, 92)"
                                                                        type="submit">Remove
                                                                        Forum
                                                                        Ban</button>
                                                                </form>
                                                            @else
                                                                <form method="post" class="flex flex-col"
                                                                    action="{{ route('forum.ban', ['userId' => $user->id]) }}">
                                                                    @csrf
                                                                    <label for="ban_duration">Ban Duration:</label>
                                                                    <select name="ban_duration" id="ban_duration">
                                                                        <option value="1">1 day</option>
                                                                        <option value="2">2 days</option>
                                                                        <option value="3">3 days</option>
                                                                        <option value="7">7 days</option>
                                                                        <!-- Permanent option -->
                                                                        <option value="permanent">Permanent</option>
                                                                    </select>
                                                                    <button
                                                                        class="bg-gray-400 border mt-1 p-1 forum_ban_button rounded-md"
                                                                        style="background-color: white" type="submit">Ban
                                                                        User</button>
                                                                </form>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </td>
                                                <td><a href="{{ route('user.show', ['userId' => $user->id]) }}"><i
                                                            class="fa fa-eye text-success"></i></a></td>
                                                <td><a href="{{ route('user.edit', ['userId' => $user->id]) }}"><i
                                                            class="fa fa-edit text-info"></i></a></td>
                                                <td><a href="#" class="text-danger"><i
                                                            class="fa fa-trash"></i>Delete</a></td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </section>
    <!--main content end-->
@endsection
