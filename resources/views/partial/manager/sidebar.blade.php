<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="#">
            <img src="images/logo.png" class="img-fluid" alt="">
            <span>Pet Care</span>
        </a>
        <div class="iq-menu-bt-sidebar">
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-more-fill"></i></div>
                    <div class="hover-circle"><i class="ri-more-2-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class="iq-menu-title"><i class="ri-subtract-line"></i><span>Bảng quản lí</span></li>
                @if(Auth::user()->hasRole('manager')||Auth::user()->hasRole('admin'))
                    <li>
                        <a href="{{route('admin.doctor.index')}}" class="iq-waves-effect"><i class="fa-solid fa-user-doctor"></i><span>Quản lí bác sĩ</span></a>
                    </li>
                    <li>
                        <a href="{{route('petList02')}}" class="iq-waves-effect"><i class="fa-solid fa-paw"></i><span>Quản lí thú cưng</span></a>
                    </li>
                    <li>
                        <a href="{{route('admin.room.index')}}" class="iq-waves-effect"><i class="fa-brands fa-intercom"></i><span>Quản lí Chuồng lưu trữ</span></a>
                    </li>
                    <li>
                        <a href="{{route('admin.typeOfService.index')}}" class="iq-waves-effect"><i class="fa-regular fa-clipboard"></i><span>Quản lí loại dịch vụ</span></a>
                    </li>
                @endif
                @if(Auth::user()->hasRole('doctor'))
                    <li>
                        <a href="{{route('petList02')}}" class="iq-waves-effect"><i class="fa-solid fa-paw"></i><span>Quản lí thú cưng</span></a>
                    </li>
                    <li>
                        <a href="{{route('doctor.calendar')}}" class="iq-waves-effect"><i class="fa-solid fa-calendar"></i><span>Lịch khám</span></a>
                    </li>
                @endif
                @if(Auth::user()->hasRole('customer'))
                    <li>
                        <a href="{{route('user.listPet')}}" class="iq-waves-effect"><i class="fa-solid fa-paw"></i><span>Danh sách thú cưng</span></a>
                    </li>
                    <li>
                        <a href="{{route('user.room.appoint')}}" class="iq-waves-effect"><i class="fa-brands fa-intercom"></i><span>Đăng kí lưu trữ thú cưng</span></a>
                    </li>
                    <li>
                        <a href="{{route('user.register.service')}}" class="iq-waves-effect"><i class="fa-solid fa-hand-holding-hand"></i><span>Đăng kí dịch vụ</span></a>
                    </li>
                    <li>
                        <a href="{{route('user.register.appoint')}}" class="iq-waves-effect"><i class="fa-solid fa-stethoscope"></i><span>Đăng kí lịch khám</span></a>
                    </li>
                    <li>
                        <a href="{{route('user.service.history')}}" class="iq-waves-effect"><i class="fa-solid fa-calendar"></i><span>Lịch sử đăng kí dịch vụ</span></a>
                    </li>
                    <li>
                        <a href="{{route('user.room.history')}}" class="iq-waves-effect"><i class="fa-solid fa-calendar"></i><span>Lịch sử đăng kí lưu trữ</span></a>
                    </li>
                    <li>
                        <a href="{{route('user.appointment.history')}}" class="iq-waves-effect"><i class="fa-solid fa-calendar"></i><span>Lịch sử đăng kí lịch khám</span></a>
                    </li>
                @endif
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
