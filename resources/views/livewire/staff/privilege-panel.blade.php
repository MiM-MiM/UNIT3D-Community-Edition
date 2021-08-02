<div class="container" xmlns:wire="http://www.w3.org/1999/xhtml">
      <div class="row">
          <div class="col-xs-12">
              <div class="panel panel-default" x-data="{ tab: 1, panel: 0, query: '', roleSlug: '',  activeUser: @entangle('activeUser') }">
                  <div class="panel-heading" style="padding-bottom: 0;">
                      <ul class="nav nav-tabs nav-justified mt-10" >
                          <li :class="{ 'active': tab === 1 }"><a href="#" @click.prevent="tab = 1; panel = 0;"><i class="fas fa-user-tag"></i> Roles</a></li>
                          <li :class="{ 'active': tab === 2 }"><a href="#" @click.prevent="tab = 2; panel = 0;"><i class="fas fa-lock"></i> Privileges</a></li>
                          <li :class="{ 'active': tab === 3 }"><a href="#" @click.prevent="tab = 3; panel = 0;"><i class="fas fa-user-lock"></i> Users</a></li>
                      </ul>
                  </div>
                  <div class="panel-body">
                        <section x-show="tab === 1 && panel == 0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Roles <small style="font-family: monospace; font-size: 9px;">[slug]</small></th>
                                        <th>Badge</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{$role->name}} <small style="font-family: monospace; font-size: 10px;">[{{$role->slug}}]</small></td>
                                        <td><span class="badge-user text-bold"
                                                  style="color:{{ $role->color }}; background-image:{{ $role->effects }}; margin-bottom: 2px;">
                            <i class="{{ $role->icon }}" data-toggle="tooltip"
                               data-original-title="{{ $role->name }}"></i> {{$role->name}} </span></td>
                                        <td><a class="btn btn-success" href="#">Edit Settings</a> <a class="btn btn-primary" @click="$wire.GetRolesPrivileges('{{$role->slug}}').then(() => { tab = 1; panel = 1; roleSlug = '{{$role->slug}}' })" href="#">Edit Privileges</a></td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </section>
                        <section x-show="tab === 2 && panel == 0">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Privilege <small style="font-family: monospace; font-size: 10px;">[slug]</small></th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($privileges as $privilege)
                                    <tr>
                                        <td>{{$privilege->name}} <small style="font-family: monospace; font-size: 10px;">[{{$privilege->slug}}]</small></td>
                                        <td>{{$privilege->description}}</td>
                                        <td><a class="btn btn-success" href="#">Edit Settings</a> <a class="btn btn-primary" href="#">Audit Usage</a></td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </section>
                        <section x-show="tab === 3 && panel == 0">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <input type="text" wire:model="userSearch" class="form-control float-right" style="width: 275px;"
                                               placeholder="@lang('user.search')"/>
                                    </div>
                                </div>
                            </div>


                            <table class="table vertical-align table-hover">
                                <tbody>
                                <tr>

                                    <th>
                                        <div sortable wire:click="sortBy('username')" :direction="$wire.sortField === 'username' ? $wire.sortDirection : null" role="button">
                                            @lang('common.username')
                                            @include('livewire.includes._sort-icon', ['field' => 'username'])
                                        </div>
                                    </th>
                                    <th>
                                        <div sortable wire:click="sortBy('role_id')" :direction="$wire.sortField === 'role_id' ? $wire.sortDirection : null" role="button">
                                            Role
                                            @include('livewire.includes._sort-icon', ['field' => 'role_id'])
                                        </div>
                                    </th>
                                    <th class="hidden-sm hidden-xs">
                                        <div sortable wire:click="sortBy('email')" :direction="$wire.sortField === 'email' ? $wire.sortDirection : null"
                                             role="button">
                                            @lang('common.email')
                                            @include('livewire.includes._sort-icon', ['field' => 'email'])
                                        </div>
                                    </th>
                                    <th class="hidden-sm hidden-xs">
                                        <div sortable wire:click="sortBy('created_at')" :direction="$wire.sortField === 'created_at' ? $wire.sortDirection : null"
                                             role="button">
                                            @lang('user.registration-date')
                                            @include('livewire.includes._sort-icon', ['field' => 'created_at'])
                                        </div>
                                    </th>
                                    <th>@lang('common.action')</th>
                                </tr>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
						<span class="badge-user text-bold">
                            {{ $user->username }}
                        </span>
                                        </td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                @if($role->slug === $user->primaryRole->slug)
                                                    <span class="badge text-bold"
                                                          style="color:{{ $user->primaryRole->color }}; background-image:{{ $user->primaryRole->effect }}; background-color: #1e1e1e">
                                                    <i class="{{ $user->primaryRole->icon }}"></i>{{ $user->primaryRole->name }}</span>
                                                @else
                                                    <span class="badge">{{$role->name}}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="hidden-sm hidden-xs">{{ $user->email }}</td>
                                        <td class="hidden-sm hidden-xs">{{ \Illuminate\Support\Carbon::make($user->created_at)->toFormattedDateString() }}</td>
                                        <td>
                                            <a class="btn btn-success" href="#"  @click.prevent="$wire.GetUser({{$user->id}}).then( ()=>{ tab = 3; panel = 2; } );">Edit Privileges & Restrictions</a>
                                            <a class="btn btn-primary" href="#">Change Primary Role</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </section>
                        <section x-show="tab === 1 && panel == 1">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Privilege <small style="font-family: monospace; font-size: 9px;">[slug]</small></th>
                                    <th>Description</th>
                                    <th style="min-width: 250px;">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($privileges as $privilege)
                                    <tr>
                                        <td>{{$privilege->name}}<small style="font-family: monospace; font-size: 9px;">[{{$privilege->slug}}]</small></td>
                                        <td>{{$privilege->description}}</td>
                                        <td>
                                                <a href="#" style="margin-right: 10px;" @click="$wire.GiveRolePrivilege( roleSlug ,'{{$privilege?->slug}}')" class="btn btn-xs {{ (!empty($rolesprivileges) && $rolesprivileges->contains($privilege) ? 'btn-success selected' : 'btn-primary selected' ) }}">Yes</a>
                                                <a href="#" style="margin-right: 10px;" class="btn btn-xs {{ (!empty($rolesprivileges) && $rolesprivileges->contains($privilege) ? 'btn-primary not-selected' : 'btn-success selected' ) }}">No</a>
                                                <a href="#" style="margin-right: 10px;" class="btn btn-xs btn-primary not-selected">Never</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </section>
                        <section x-show="tab === 3 && panel === 2">
                            @if(isset($ActiveUser) && !empty($ActiveUser))
                            <div>
                                <p>Username: {{ $ActiveUser->username }} User ID: {{ $ActiveUser->id }} </p>
                            </div>

                            <table class="table">
                                  <thead>
                                  <tr>
                                      <th>Privilege <small style="font-family: monospace; font-size: 9px;">[slug]</small></th>
                                      <th>Description</th>
                                      <th style="min-width: 250px;">Status</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($privileges as $privilege)
                                      <tr>
                                          <td>{{$privilege->name}}<small style="font-family: monospace; font-size: 9px;">[{{$privilege->slug}}]</small></td>
                                          <td>{{$privilege->description}}</td>
                                          <td>
                                                  <a href="#" style="margin-right: 10px;" @click.prevent="$wire.GiveUserPrivilege({{$ActiveUser->id}}, '{{$privilege->slug}}')" class="btn btn-xs {{ $ActiveUser->hasPrivilegeTo($privilege->slug) && !$ActiveUser->hasPrivilegeThroughRole($privilege) ? 'btn-success selected' : 'btn-primary not-selected'}}" {{ $ActiveUser->hasPrivilegeThroughRole($privilege) ? 'disabled' : '' }}>User Level</a>
                                                  <a href="#" style="margin-right: 10px;" class="btn btn-xs {{ $ActiveUser->hasPrivilegeThroughRole($privilege) ? 'btn-success selected' : 'btn-primary not-selected'}}">By Role</a>
                                                  <a href="#" style="margin-right: 10px;" class="btn btn-xs btn-primary not-selected">Never</a>
                                          </td>
                                      </tr>
                                  @endforeach
                                  </tbody>
                              </table>
                             @endif
                      </section>
                  </div>
              </div>
          </div>
      </div>
</div>