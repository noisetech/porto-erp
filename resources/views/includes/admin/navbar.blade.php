   <div class="d-none d-xl-block">
       <div class="header-inner d-flex align-items-center justify-content-around justify-content-xl-between flex-wrap flex-xl-nowrap gap-3 gap-xl-5">
           <div class="header-left-part d-flex align-items-center flex-grow-1 w-100">

           </div>

           <div class="header-right-part d-flex align-items-center flex-shrink-0">
               <ul class="nav-elements d-flex align-items-center list-unstyled m-0 p-0">
                   <li class="nav-item nav-color-switch d-flex align-items-center gap-3">
                       <div class="sun"><img src="{{ asset('assets/be/assets/img/sun.svg') }}" alt="img"></div>
                       <div class="switch">
                           <input type="checkbox" id="colorSwitch" value="false" name="defaultMode">
                           <div class="shutter">
                               <span class="lbl-off"></span>
                               <span class="lbl-on"></span>
                               <div class="slider bg-primary"></div>
                           </div>
                       </div>
                       <div class="moon"><img src="{{ asset('assets/be/assets/img/moon.svg') }}" alt="img"></div>
                   </li>


                   <li class="nav-item nav-notification dropdown">
                       <a href="#" class="nav-toggler" data-bs-toggle="dropdown" aria-expanded="false">
                           <img src="{{ asset('assets/be/assets/img/svg/bell.svg') }}" alt="bell">
                           <div class="badge rounded-circle">12</div>
                       </a>
                       <div class="dropdown-widget dropdown-menu p-0">
                           <div class="dropdown-wrapper pd-50">
                               <div class="dropdown-wrapper--title">
                                   <h4 class="d-flex align-items-center justify-content-between">Notifications <a href="#">View All</a></h4>
                               </div>
                               <ul class="notification-board list-unstyled">
                                   <li class="author-online has-new-message d-flex gap-3">
                                       <div class="media bg-primary text-white">
                                           <i class="bi bi-lightning"></i>
                                       </div>
                                       <div class="user-message">
                                           <h6 class="message"><a href="#">Jackie Kun</a> mentioned you at <a href="#">Kleon Projects</a></h6>
                                           <p class="message-footer d-flex align-items-center justify-content-between"> <span class="fs-14 text-gray fw-normal">2m ago</span> <span>Mark as read</span></p>
                                       </div>
                                   </li>
                                   <li class="author-online has-new-message d-flex gap-3">
                                       <div class="media bg-secondary text-white">
                                           <i class="bi bi-lightning"></i>
                                       </div>
                                       <div class="user-message">
                                           <h6 class="message"><a href="#">Olivia Johanna</a> has created new task at <a href="#">Kleon Projects</a></h6>
                                           <p class="message-footer d-flex align-items-center justify-content-between"> <span class="fs-14 text-gray fw-normal">2m ago</span> <span>Mark as read</span></p>
                                       </div>
                                   </li>
                                   <li class="author-online has-new-message d-flex gap-3">
                                       <div class="media media-outline-red text-red">
                                           <i class="bi bi-clock-fill"></i>
                                       </div>
                                       <div class="user-message">
                                           <h6 class="message">[REMINDER] Due date of <a href="#">Highspeed Studios Projects</a> te task will be coming</h6>
                                           <p class="message-footer d-flex align-items-center justify-content-between"> <span class="fs-14 text-gray fw-normal">2m ago</span> <span>Mark as read</span></p>
                                       </div>
                                   </li>
                               </ul>
                               <h6 class="all-notifications"> <a href="#" class="btn bg-muted text-primary w-100 fw-bold mt-3 ff-heading px-0">View All Notifications</a> </h6>
                           </div>
                       </div>
                   </li>

                   <li class="nav-item nav-settings">
                       <a href="#" class="nav-toggler">
                           <img src="{{ asset('assets/be/assets/img/svg/settings.svg') }}" alt="img">
                       </a>
                   </li>

                   <li class="nav-item nav-author">
                       <a href="#" class="nav-toggler" data-bs-toggle="dropdown" aria-expanded="false">
                           <img src="{{ asset('assets/be/assets/img/nav_author.jpg') }}" alt="img" width="54" class="rounded-2">
                           <div class="nav-toggler-content">
                               <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                           </div>
                       </a>
                       <div class="dropdown-widget dropdown-menu p-0 admin-card">
                           <div class="dropdown-wrapper">
                               <div class="card mb-0">
                                   <div class="card-header p-3 text-center">
                                       <img src="{{ asset('assets/be/assets/img/nav_author.jpg') }}" alt="img" width="80" class="rounded-circle avatar">
                                       <div class="mt-2">
                                           <h6 class="mb-0 lh-18">Franklin Jr.</h6>
                                           <div class="fs-14 fw-normal text-gray">Super Admin</div>
                                       </div>
                                   </div>
                                   <div class="card-body p-3">
                                       <ul class="list-unstyled p-0 m-0">
                                           <li>
                                               <a href="profile.html" class="fs-14 fw-normal text-dark d-block p-1"><i class="bi bi-person me-2"></i> Profile</a>
                                           </li>
                                           <li>
                                               <a href="email.html" class="fs-14 fw-normal text-dark d-block p-1"><i class="bi bi-envelope me-2 "></i> Inbox</a>
                                           </li>
                                           <li>
                                               <a href="#" class="fs-14 fw-normal text-dark d-block p-1"><i class="bi bi-gear me-2"></i> Setting & Privacy</a>
                                           </li>
                                       </ul>

                                   </div>
                                   <div class="card-footer p-3">
                                       <form action="{{ route('logout') }}" method="post">
                                           @csrf

                                           <button class="btn btn-outline-gray bg-transparent w-100 py-1 rounded-1 text-dark fs-14 fw-medium">
                                               <i class="bi bi-box-arrow-right"></i> Logout

                                           </button>
                                       </form>

                                   </div>
                               </div>
                           </div>
                       </div>
                   </li>
               </ul>
           </div>
       </div>
   </div>
