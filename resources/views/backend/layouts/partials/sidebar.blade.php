 <!-- sidebar menu area start -->
 @php
     $usr = Auth::guard('admin')->user();
 @endphp
 <div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-white">BKM</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                    <li class="active">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                        <ul class="collapse">
                            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('role.create') || $usr->can('role.view') ||  $usr->can('role.edit') ||  $usr->can('role.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                            Roles & Permissions
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'in' : '' }}">
                            @if ($usr->can('role.view'))
                                <li class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                            @endif
                            @if ($usr->can('role.create'))
                                <li class="{{ Route::is('admin.roles.create')  ? 'active' : '' }}"><a href="{{ route('admin.roles.create') }}">Create Role</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    
                    @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Admins
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}">All Admins</a></li>
                            @endif

                            @if ($usr->can('admin.create'))
                                <li class="{{ Route::is('admin.admins.create')  ? 'active' : '' }}"><a href="{{ route('admin.admins.create') }}">Create Admin</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('ad.create') || $usr->can('ad.view') ||  $usr->can('ad.edit') ||  $usr->can('ad.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                Ads
                            </span></a>
                            <ul class="collapse {{ Route::is('admin.ad.create') || Route::is('admin.ad.index') || Route::is('admin.ad.edit') || Route::is('admin.ad.show') ? 'in' : '' }}">
                                @if ($usr->can('ad.create'))
                                    <li class="{{ Route::is('admin.ad.create')  ? 'active' : '' }}"><a href="{{ route('admin.ad.create') }}">Ads</a></li>
                                @endif
                                @if ($usr->can('ad.view'))
                                    <li class="{{ Route::is('admin.ad.index')  || Route::is('admin.ad.edit') ? 'active' : '' }}"><a href="{{ route('admin.ad.index') }}">Ads List</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($usr->can('country.create') || $usr->can('country.view') ||  $usr->can('country.edit') ||  $usr->can('country.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                Country
                            </span></a>
                            <ul class="collapse {{ Route::is('country.create') || Route::is('country.index') || Route::is('country.edit') || Route::is('country.show') ? 'in' : '' }}">
                                @if ($usr->can('country.create'))
                                    <li class="{{ Route::is('country.create')  ? 'active' : '' }}"><a href="{{ route('country.create') }}">Add Country</a></li>
                                @endif
                                @if ($usr->can('country.view'))
                                    <li class="{{ Route::is('country.index')  || Route::is('country.edit') ? 'active' : '' }}"><a href="{{ route('country.index') }}"> Country List</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($usr->can('state.create') || $usr->can('state.view') ||  $usr->can('state.edit') ||  $usr->can('state.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                State
                            </span></a>
                            <ul class="collapse {{ Route::is('state.create') || Route::is('state.index') || Route::is('state.edit') || Route::is('state.show') ? 'in' : '' }}">
                                @if ($usr->can('state.create'))
                                    <li class="{{ Route::is('state.create')  ? 'active' : '' }}"><a href="{{ route('state.create') }}">Add State</a></li>
                                @endif
                                @if ($usr->can('state.view'))
                                    <li class="{{ Route::is('state.index')  || Route::is('state.edit') ? 'active' : '' }}"><a href="{{ route('state.index') }}"> State List</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($usr->can('district.create') || $usr->can('district.view') ||  $usr->can('district.edit') ||  $usr->can('district.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                District
                            </span></a>
                            <ul class="collapse {{ Route::is('district.create') || Route::is('district.index') || Route::is('district.edit') || Route::is('district.show') ? 'in' : '' }}">
                                @if ($usr->can('district.create'))
                                    <li class="{{ Route::is('district.create')  ? 'active' : '' }}"><a href="{{ route('district.create') }}">Add District</a></li>
                                @endif
                                @if ($usr->can('district.view'))
                                    <li class="{{ Route::is('district.index')  || Route::is('district.edit') ? 'active' : '' }}"><a href="{{ route('district.index') }}"> District List</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($usr->can('pincode.create') || $usr->can('pincode.view') ||  $usr->can('pincode.edit') ||  $usr->can('pincode.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                Pincode
                            </span></a>
                            <ul class="collapse {{ Route::is('pin-codes.create') || Route::is('pin-codes.index') || Route::is('pin-codes.edit') || Route::is('pin-codes.show') ? 'in' : '' }}">
                                @if ($usr->can('pincode.create'))
                                    <li class="{{ Route::is('pin-codes.create')  ? 'active' : '' }}"><a href="{{ route('pin-codes.create') }}">Add Pincode</a></li>
                                @endif
                                @if ($usr->can('pincode.view'))
                                    <li class="{{ Route::is('pin-codes.index')  || Route::is('pin-codes.edit') ? 'active' : '' }}"><a href="{{ route('pin-codes.index') }}"> Pincode List</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($usr->can('market_place.create') || $usr->can('market_place.view') ||  $usr->can('market_place.edit') ||  $usr->can('market_place.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                Marketplace
                            </span></a>
                            <ul class="collapse {{ Route::is('market-places.create') || Route::is('market-places.index') || Route::is('market-places.edit') || Route::is('market-places.show') ? 'in' : '' }}">
                                @if ($usr->can('market_place.create'))
                                    <li class="{{ Route::is('market-places.create')  ? 'active' : '' }}"><a href="{{ route('market-places.create') }}">Add Marketplace</a></li>
                                @endif
                                @if ($usr->can('market_place.view'))
                                    <li class="{{ Route::is('market-places.index')  || Route::is('market-places.edit') ? 'active' : '' }}"><a href="{{ route('market-places.index') }}"> Marketplace</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($usr->can('vending.create') || $usr->can('vending.view') ||  $usr->can('vending.edit') ||  $usr->can('vending.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                Vending
                            </span></a>
                            <ul class="collapse {{ Route::is('vending.create') || Route::is('vending.index') || Route::is('vending.edit') || Route::is('vending.show') ? 'in' : '' }}">
                                @if ($usr->can('vending.create'))
                                    <li class="{{ Route::is('vending.create')  ? 'active' : '' }}"><a href="{{ route('vending.create') }}">Vending</a></li>
                                @endif
                                @if ($usr->can('vending.view'))
                                    <li class="{{ Route::is('vending.index')  || Route::is('vending.edit') ? 'active' : '' }}"><a href="{{ route('vending.index') }}"> Vending List</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if ($usr->can('membership.create') || $usr->can('membership.view') ||  $usr->can('membership.edit') ||  $usr->can('membership.delete'))
                        <li>
                            <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                Membership Details
                            </span></a>
                            <ul class="collapse {{ Route::is('memberships.create') || Route::is('memberships.index') || Route::is('memberships.edit') || Route::is('memberships.show') ? 'in' : '' }}">
                                @if ($usr->can('membership.create'))
                                    <li class="{{ Route::is('memberships.create')  ? 'active' : '' }}"><a href="{{ route('memberships.create') }}">View / Apply</a></li>
                                @endif
                                @if ($usr->can('membership.view'))
                                    <li class="{{ Route::is('memberships.index')  || Route::is('memberships.edit') ? 'active' : '' }}"><a href="{{ route('memberships.index') }}">Subscription</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->