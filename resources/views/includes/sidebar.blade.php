<?php
    $segment = Request::segments();
?>
<aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <!-- <div class="user-info">
                <div class="image">
                    <img src="{{URL::asset('adminLTE/images/user.png')}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user() ? Auth::user()->first_name : ''}}</div>
                    <div class="email">{{Auth::user() ? Auth::user()->email : ''}}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{URL::to('logout')}}"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                @foreach($menu as $key => $value)
                    @if(isset($value->child))
                    <?php
                    $active = '';
                    foreach ($value->child as $keyC => $valueC){
                        if($value->id == $valueC->parent_id && $segment[0] == $valueC->routes){
                            $active = 'active';
                            break;
                        }
                        
                    } ?>
                        <li class="<?php echo $active ?>">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">{{ $value->icon }}</i>
                                @if(session::get('locale') == 'en')
                                <span>{{ $value->menu }}</span>
                                @else
                                <span>{{ $value->menu_ar }}</span>
                                @endif
                            </a>
                            <ul class="ml-menu">
                            @foreach ($value->child as $keyC => $valueC)
                                <li>
                                @if($valueC->menu )
                                    <a href="{{URL::to($valueC->routes)}}">
                                        @if(session::get('locale') == 'en')
                                            <span>{{ $valueC->menu }}</span>
                                        @else
                                            <span>{{ $valueC->menu_ar }}</span>
                                        @endif
                                    </a>
                                @endif
                                </li>
                            @endforeach
                            </ul>
                        </li>
                    @else 
                    <li class="<?php echo $segment[0] == $value->routes ? 'active' : '' ?>">
                        <a href="{{URL::to($value->routes)}}">
                            <i class="material-icons">{{ $value->icon }}</i>
                                @if(session::get('locale') == 'en')
                                    <span>{{ $value->menu }}</span>
                                @else
                                    <span>{{ $value->menu_ar }}</span>
                                @endif
                        </a>
                    </li>
                    @endif
                @endforeach
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <!-- <div class="legal bg_legal">
                <div class="copyright">
                    &copy; 2019 - 2020 <a href="javascript:void(0);">@lang('language.appName')</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div> -->
            <!-- #Footer -->
        </aside>