@extends('common.page.Master')
@section('noi_dung')
<div class="page-content">
<div class="chat-wrapper" style="height: 800px;">
					<div class="chat-sidebar">					
						<div class="chat-sidebar-content">
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-Chats">
								<div class="chat-sidebar-header">
							<div class="d-flex align-items-center">
								<div class="flex-grow-1 ms-2">
								<div class="chat-tab-menu mt-3">
								<ul class="nav nav-pills nav-justified">
									<li class="nav-item">
										<a class="nav-link active" data-bs-toggle="pill" href="javascript:;">
											<div class="font-24"><i class='bx bx-conversation font-30'></i>
											</div>
											<div><small>All khách hàng</small>
											</div>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="pill" href="javascript:;">
											<div class="font-24"><i class='fadeIn animated bx bx-message-alt-error font-30'></i>
											</div>
											<div><small>Chưa ghim</small>
											</div>
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="pill" href="javascript:;">
											<div class="font-24"><i class='fadeIn animated bx bx-message-alt-check font-30'></i>
											</div>
											<div><small>Đang ghim</small>
											</div>
										</a>
									</li>

								</ul>
							</div>
								</div>
								<!-- <div class="dropdown">
									<div class="cursor-pointer font-24 dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded'></i>
									</div>
									<div class="dropdown-menu dropdown-menu-end"> <a class="dropdown-item" href="javascript:;">Settings</a>
										<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Help & Feedback</a>
										<a class="dropdown-item" href="javascript:;">Enable Split View Mode</a>
										<a class="dropdown-item" href="javascript:;">Keyboard Shortcuts</a>
										<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Sign Out</a>
									</div>
								</div> -->
							</div>
							<div class="mb-3"></div>
							<div class="input-group input-group-sm"> <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
								<input type="text" class="form-control" placeholder="Tìm kiếm khách hàng">
							</div>
</div>
								<div class="p-3 mt-2"> <a class="text-uppercase text-secondary dropdown-toggle dropdown-toggle-nocaret" >  Danh sách tin nhắn </a>
											<div class="dropdown-menu">	<a class="dropdown-item" href="#">Recent Chats</a>
												<a class="dropdown-item" href="#">Hidden Chats</a>
												<div class="dropdown-divider"></div>	<a class="dropdown-item" href="#">Sort by Time</a>
												<a class="dropdown-item" href="#">Sort by Unread</a>
												<div class="dropdown-divider"></div>	<a class="dropdown-item" href="#">Show Favorites</a>
											</div>
										</div>
									<div class="chat-list" style="height: 700px;">
										<div class="list-group list-group-flush">
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-2.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(1)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>

												</div>
											</a>
											<a href="javascript:;" class="list-group-item active">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-3.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Chị Đông</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(2)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-4.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(3)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-5.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														 <h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(4)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-6.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(5)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-7.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(6)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-9.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(7)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-10.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(8)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(8)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(9)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(10)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(11)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(12)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(13)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
											<a href="javascript:;" class="list-group-item">
												<div class="d-flex">
													<div class="chat-user-online">
														<img src="/assets/images/avatars/avatar-11.png" width="42" height="42" class="rounded-circle" alt="" />
													</div>
													<div class="flex-grow-1 ms-2">
														<h6 class="mb-0 chat-title">Minh Nhật</h6>
														<p class="mb-0 chat-msg">ngphtai.it+1@gmail.com</p>
													</div>
													<div style="position: relative; display: inline-block;">
  <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(14)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
  <span class="icon-name" style="position: absolute; top: -20px; right: 100%; background-color: #f2f2f2; color: #333; padding: 5px; border-radius: 5px; display: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">van A</span>
</div>
												</div>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="chat-header d-flex align-items-center">
						<div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i>
						</div>
						<div>
							<h4 class="mb-1 font-weight-bold">Chị Đông</h4>
							<div class="list-inline d-sm-flex mb-0 d-none"> <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary"><small class='bx bxs-circle me-1 chart-online'></small>Nhân viên đã ghim</a>
								<a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary">|</a>
								<a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary"><i class='fadeIn animated bx bx-user me-1'></i>Yến Nhi</a>
								<a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary">|</a>
								<a class="list-inline-item d-flex align-items-center text-secondary" onclick="toggleSearch()"><i class='bx bx-search me-1'></i>Find</a> <div class="search-container" style="display: none;">
								<input type="text" class="form-control" placeholder="Tìm kiếm tin nhắn">
  </div>
							</div>
						</div>
						
						<div class="chat-top-header-menu ms-auto"> 
						<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">	<i class='fadeIn animated bx bx-user'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<div class="row row-cols-1 g-3 p-3">
										<div class="col text-center">

										<div class="card-body text-center">
								<div class="border radius-15">
									<img src="/assets/images/avatars/avatar-1.png" width="110" height="110" class="rounded-circle shadow" alt="">
									<h5 class="mb-1 mt-2">Phạm Thị Duy Đông</h5>
									<p class="mb-0">Chiongnaunaunaunau@gmail.com</p>
									<!-- <p class="mb-3">gmail khách hàng: ngphtai.it+1@gmail.com</p> -->
									<hr class="my-3" />
										<ul class="list-group list-group-flush">
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Email NV</h6>
												<span class="text-secondary">ngphtai.it+1@gmail.com</span>
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone-call me-2 icon-inline"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>Số điện thoại:</h6>
												<span class="text-secondary">0905 550 895</span>
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock me-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>Thời gian thực hiện:</h6>
												<span class="text-secondary">13:20 28/04</span>
											</li>
											
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter me-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Ghi chú:</h6>
												<span class="text-secondary">Khách hàng tìm năng</span>
											</li>
										</ul>
								</div>
							</div>
										</div>

									</div>
								</div>
							</li>
						
							</a>
						</div>
					</div>
					<div class="chat-content" style="height: 700px;">
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">2:35 PM</p>
									<p class="chat-left-msg">xin chao</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex ms-auto">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">2:37 PM</p>
									<p class="chat-right-msg">chào</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">2:48 PM</p>
									<p class="chat-left-msg">uk chào</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">2:49 PM</p>
									<p class="chat-right-msg">ừ chào</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">3:12 PM</p>
									<p class="chat-left-msg">nha` bán yến j z e</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">3:14 PM</p>
									<p class="chat-right-msg">yến chưng nóng ạ! chị có thể xem menu ở đây ạ</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">3:16 PM</p>
									<p class="chat-left-msg">ừ cho chị 5 hủ yến 200lm</p>
									<p class="chat-left-msg">2 hủ yến đường phèn</p>
									<p class="chat-left-msg">3 hủ yến chưng táo đỏ thêm 2 long nhân với đông trùng hạ thảo nha e</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">3:22 PM</p>
									<p class="chat-right-msg">Vâng ạ! ship tới địa chỉ nào ạ</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">3:16 PM</p>
									<p class="chat-left-msg">Tới 254 Lê Đại Hành nha e</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">3:30 PM</p>
									<p class="chat-right-msg">Oke của chị hết 750k</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">3:33 PM</p>
									<p class="chat-left-msg">oke e ship nhanh qua cho chị nha</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">3:35 PM</p>
									<p class="chat-right-msg">oke chị iu</p>
								</div>
							</div>
						</div>
					</div>
					<div class="chat-footer d-flex align-items-center">
						<div class="flex-grow-1 pe-2">
							<div class="input-group">	
								<input type="text" class="form-control" placeholder="Type a message">
							</div>
						</div>
						<div class="chat-footer-menu"> <a href="javascript:;"><i class='fadeIn animated bx bx-paper-plane'></i></a>
						</div>
					</div>
					<!--start chat overlay-->
					<div class="overlay chat-toggle-btn-mobile"></div>
					<!--end chat overlay-->
				</div>
			</div>
			<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script>
		new PerfectScrollbar('.chat-list');
		new PerfectScrollbar('.chat-content');
	</script>
	<!--app JS-->
	<script src="/assets/js/app.js"></script>

	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/assets/plugins/input-tags/js/tagsinput.js"></script>
	<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--app JS-->
	<script>
  function toggleCheckbox(checkboxIndex) {
    var checkboxIcon = document.querySelectorAll('.checkbox-icon')[checkboxIndex - 1];

    if (checkboxIcon.classList.contains('bx-plus')) {
      checkboxIcon.classList.remove('bx-plus');
      checkboxIcon.classList.add('bx-pin');
    } else {
      checkboxIcon.classList.remove('bx-pin');
      checkboxIcon.classList.add('bx-plus');
    }
  }
</script>
<script>
    function toggleSearch() {
      var searchContainer = document.querySelector('.search-container');

      if (searchContainer.style.display === 'none') {
        searchContainer.style.display = 'block';
      } else {
        searchContainer.style.display = 'none';
      }
    }
	function showName(name, icon) {
    var nameElement = icon.nextElementSibling;
    nameElement.innerText = name;
    nameElement.style.display = 'inline';
  }

  function hideName(icon) {
    var nameElement = icon.nextElementSibling;
    nameElement.style.display = 'none';
  }
  </script>
				@endSection