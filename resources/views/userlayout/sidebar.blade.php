  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion"  style="background: linear-gradient(60deg, #ff6933, #ff6933);" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Welcome<sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Homepage
    </div>


    <li class="nav-item">
      <a class="nav-link" href="{{ route('AddOtherGoals') }}">
        <i class="fas fa-paste"></i>
        <span>เพิ่มตัวชี้วัด</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="far fa-edit"></i>
        <span>เข้าทำประเมิน</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="far fa-check-circle"></i>
        <span>ผลการประเมิน</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('PMS_logout') }}">
        <i class="fas fa-sign-out-alt"></i>
        <span>ออกจากระบบ</span>
      </a>
    </li>
  </ul>
  <!-- End of Sidebar -->