@extends('common.page.Master')
@section('noi_dung')

    <div class="page-content">
        <!--breadcrumb-->

        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Product" style="width: 600px;">
                        <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                    </div>
                    {{-- button add ( cái hiển thị của nó là Add New Product--}}
                    <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#adddProduct">
                    <a class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Product</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order#</th>
                                <th>Company Name</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>View Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000354</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>FulFilled</div></td>
                                <td>$485.20</td>
                                <td>June 10, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000986</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>Confirmed</div></td>
                                <td>$650.30</td>
                                <td>June 12, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000536</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>Partially shipped</div></td>
                                <td>$159.45</td>
                                <td>June 14, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000678</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>FulFilled</div></td>
                                <td>$968.40</td>
                                <td>June 16, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000457</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>Confirmed</div></td>
                                <td>$689.50</td>
                                <td>June 18, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000685</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>Confirmed</div></td>
                                <td>$478.60</td>
                                <td>June 20, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000356</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>Partially shipped</div></td>
                                <td>$523.30</td>
                                <td>June 21, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000875</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>FulFilled</div></td>
                                <td>$960.20</td>
                                <td>June 24, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000658</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>FulFilled</div></td>
                                <td>$428.10</td>
                                <td>June 25, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#OS-000689</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Gaspur Antunes</td>
                                <td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>Partially shipped</div></td>
                                <td>$876.60</td>
                                <td>June 26, 2020</td>
                                <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Add New Product -->
                <div class="modal fade" id="adddProduct" tabindex="-1" aria-labelledby="adddProduct" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="adddProduct">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        ...
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection
