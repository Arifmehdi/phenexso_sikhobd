@extends('admin.master')
@section('title',"Admin Dashboard | User Show")
@section('body')
    <section class="pt-5">
        <div class="container">
            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:160px;">Photo</th>
                        <td>
                            @if($user->image)
                                <img src="{{ asset('storage/users/' . $user->image) }}" alt="{{ $user->name }}"
                                     style="width:110px; height:110px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0;">
                            @else
                                <span style="width:110px; height:110px; display:inline-flex; align-items:center; justify-content:center; border-radius:8px; background:#6c5ce7; color:#fff; font-size:32px; font-weight:700;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{$user->mobile}}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                            <td>{{ Str::ucfirst($user->role == 0 ? 'buyer' : $user->role) }}</td>
                        {{--@if(isset($user->roles))
                            <td>
                                @foreach($user->roles as $role)
                                    {{$role->role_name}}
                                @endforeach
                            </td>
                        @else
                            <td>{{ $user->role = 0 ? 'Buyer' : $user->role }}</td>
                        @endif--}}

                    </tr>
                </table>
            </div>
        </div>
    </section>
@endsection
