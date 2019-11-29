@extends('web.admin.layout.master')

@section('page-title','Главная')
@section('page-subtitle','Общие отчеты и графики')

@section('content')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="widget">
                    <div class="widget-heading clearfix">
                        <h3 class="widget-title pull-left">Order Status</h3>
                        <ul class="widget-tools pull-right list-inline">
                            <li><a href="javascript:;" class="widget-collapse"><i class="ti-angle-up"></i></a></li>
                            <li><a href="javascript:;" class="widget-reload"><i class="ti-reload"></i></a></li>
                            <li><a href="javascript:;" class="widget-remove"><i class="ti-close"></i></a></li>
                        </ul>
                    </div>
                    <div class="widget-body">
                        <div id="flot-order" style="height: 302px"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="widget no-border p-15 bg-purple media">
                            <div class="media-left media-middle"><i class="media-object ti-shopping-cart fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Transactions</h6>
                                <div class="fs-20">685 <span class="fs-12"><i class="ti-arrow-up fs-10"></i> 8%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget no-border p-15 bg-success media">
                            <div class="media-left media-middle"><i class="media-object ti-user fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Sales</h6>
                                <div class="fs-20">532 <span class="fs-12"><i class="ti-arrow-up fs-10"></i> 4%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget no-border p-15 bg-danger media">
                            <div class="media-left media-middle"><i class="media-object ti-trash fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Cancels</h6>
                                <div class="fs-20">20 <span class="fs-12"><i class="ti-arrow-down fs-10"></i> 3%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget no-border p-15 bg-warning media">
                            <div class="media-left media-middle"><i class="media-object ti-paint-bucket fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Refunds</h6>
                                <div class="fs-20">20 <span class="fs-12"><i class="ti-arrow-down fs-10"></i> 4%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget no-border p-15 bg-info media">
                            <div class="media-left media-middle"><i class="media-object ti-direction-alt fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Chargebacks</h6>
                                <div class="fs-20">24 <span class="fs-12"><i class="ti-arrow-down fs-10"></i> 2%</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="widget no-border p-15 bg-primary media">
                            <div class="media-left media-middle"><i class="media-object ti-email fs-36"></i></div>
                            <div class="media-body">
                                <h6 class="m-0">Emails</h6>
                                <div class="fs-20">6114 <span class="fs-12"><i class="ti-arrow-up fs-10"></i> 4%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget no-border p-20 bg-black">
                    <div class="media">
                        <div class="media-left media-middle pr-15"><i class="ti-pulse fs-60"></i></div>
                        <div class="media-body">
                            <ul class="list-unstyled fs-12 mb-0">
                                <li class="pt-5 pb-5">
                                    <div class="block clearfix mb-5"><span class="pull-left text-white">Upload</span><span class="pull-right text-white">1.457 MB/s</span></div>
                                    <div class="progress progress-xs bg-light mb-0">
                                        <div role="progressbar" data-transitiongoal="65" aria-valuenow="65" style="width: 65%;" class="progress-bar progress-bar-white"></div>
                                    </div>
                                </li>
                                <li class="pt-5 pb-5">
                                    <div class="block clearfix mb-5"><span class="pull-left text-white">Download</span><span class="pull-right text-white">2.864 MB/s</span></div>
                                    <div class="progress progress-xs bg-light mb-0">
                                        <div role="progressbar" data-transitiongoal="80" aria-valuenow="80" style="width: 80%;" class="progress-bar progress-bar-white"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="widget">
                    <div class="widget-heading clearfix">
                        <h3 class="widget-title pull-left">Referral Sources</h3>
                        <ul class="widget-tools pull-right list-inline">
                            <li><a href="javascript:;" class="widget-collapse"><i class="ti-angle-up"></i></a></li>
                            <li><a href="javascript:;" class="widget-reload"><i class="ti-reload"></i></a></li>
                            <li><a href="javascript:;" class="widget-remove"><i class="ti-close"></i></a></li>
                        </ul>
                    </div>
                    <div class="widget-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th>Source</th>
                                    <th>New sessions</th>
                                    <th>New users</th>
                                    <th>Bounce rate</th>
                                    <th>Pages/session</th>
                                    <th>Avg. session</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><i class="ti-google mo-sm img-circle bg-danger block text-center"></i></td>
                                    <td>33.95%</td>
                                    <td>1,620</td>
                                    <td>23.43%</td>
                                    <td>33.54</td>
                                    <td>00:20:28</td>
                                </tr>
                                <tr>
                                    <td><i class="ti-tumblr-alt mo-sm img-circle bg-black block text-center"></i></td>
                                    <td>27.43%</td>
                                    <td>2,861 </td>
                                    <td>49.21%</td>
                                    <td>29.12</td>
                                    <td>00:14:49</td>
                                </tr>
                                <tr>
                                    <td><i class="ti-facebook mo-sm img-circle bg-primary block text-center"></i></td>
                                    <td>50.29%</td>
                                    <td>1,790 </td>
                                    <td>15.68%</td>
                                    <td>50.78</td>
                                    <td>00:10:52</td>
                                </tr>
                                <tr>
                                    <td><i class="ti-twitter-alt mo-sm img-circle bg-info block text-center"></i></td>
                                    <td>14.54%</td>
                                    <td>3,786 </td>
                                    <td>12.79%</td>
                                    <td>42.69</td>
                                    <td>00:28:12</td>
                                </tr>
                                <tr>
                                    <td><i class="ti-soundcloud mo-sm img-circle bg-warning block text-center"></i></td>
                                    <td>30.12%</td>
                                    <td>1,823 </td>
                                    <td>32.93%</td>
                                    <td>63.19</td>
                                    <td>00:15:43</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-heading clearfix">
                        <h3 class="widget-title pull-left">Monthly Sales</h3>
                        <ul class="widget-tools pull-right list-inline">
                            <li><a href="javascript:;" class="widget-collapse"><i class="ti-angle-up"></i></a></li>
                            <li><a href="javascript:;" class="widget-reload"><i class="ti-reload"></i></a></li>
                            <li><a href="javascript:;" class="widget-remove"><i class="ti-close"></i></a></li>
                        </ul>
                    </div>
                    <div class="widget-body">
                        <div id="flot-sales" style="height: 313px"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget">
                    <div class="widget-heading clearfix">
                        <h3 class="widget-title pull-left">Top 3 Categories</h3>
                        <ul class="widget-tools pull-right list-inline">
                            <li><a href="javascript:;" class="widget-remove"><i class="ti-close"></i></a></li>
                        </ul>
                    </div>
                    <div class="widget-body">
                        <div id="morris-category" style="height: 224px"></div>
                        <div style="margin: 0 -20px -20px -20px" class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                <tr>
                                    <th style="width:40%">Categories</th>
                                    <th style="width:30%">Sales</th>
                                    <th style="width:30%">Up/Down</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Cosmetics</td>
                                    <td>4,325</td>
                                    <td class="text-success">+3.26%</td>
                                </tr>
                                <tr>
                                    <td>Accessories</td>
                                    <td>3,257</td>
                                    <td class="text-danger">-2.14%</td>
                                </tr>
                                <tr>
                                    <td>Books</td>
                                    <td>2,314</td>
                                    <td class="text-success">+2.92%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-heading clearfix no-border">
                        <h3 class="widget-title pull-left">Recent Transactions</h3>
                        <ul class="widget-tools pull-right list-inline">
                            <li><a href="javascript:;" class="widget-remove"><i class="ti-close"></i></a></li>
                        </ul>
                    </div>
                    <div class="widget-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                <tr>
                                    <td>Advertising</td>
                                    <td><span class="text-muted">06/23/2016</span></td>
                                    <td><span class="text-success">+2.34</span></td>
                                </tr>
                                <tr>
                                    <td>eBanking</td>
                                    <td><span class="text-muted">06/20/2016</span></td>
                                    <td><span class="text-danger">-4.29</span></td>
                                </tr>
                                <tr>
                                    <td>Google</td>
                                    <td><span class="text-muted">06/18/2016</span></td>
                                    <td><span class="text-danger">-1.32</span></td>
                                </tr>
                                <tr>
                                    <td>Facebook</td>
                                    <td><span class="text-muted">06/17/2016</span></td>
                                    <td><span class="text-success">+3.56</span></td>
                                </tr>
                                <tr>
                                    <td>Youtube</td>
                                    <td><span class="text-muted">06/15/2016</span></td>
                                    <td><span class="text-danger">-5.58</span></td>
                                </tr>
                                <tr>
                                    <td>Twitter</td>
                                    <td><span class="text-muted">06/14/2016</span></td>
                                    <td><span class="text-danger">-2.18</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="widget no-border">
                    <table id="order-table" style="width: 100%" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th style="width:10%">Order ID</th>
                            <th style="width:25%">Customer</th>
                            <th style="width:15%" class="text-center">Date Added</th>
                            <th style="width:15%" class="text-center">Date Modified</th>
                            <th style="width:10%" class="text-right">Total</th>
                            <th style="width:10%" class="text-center">Status</th>
                            <th style="width:15%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>#6546</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/10.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Philip Fernandez</h5>
                                        <p class="text-muted mb-0">489 Rhapsody Street</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$140.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#6941</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/20.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Mary Carr</h5>
                                        <p class="text-muted mb-0">3611 West Fork Drive</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$120.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#3202</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/11.jpg" alt="" class="media-object img-circle"><span class="status bg-danger"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Joseph Salazar</h5>
                                        <p class="text-muted mb-0">4489 Hart Ridge Road</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$590.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#8302</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/06.jpg" alt="" class="media-object img-circle"><span class="status bg-warning"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">John Cruz</h5>
                                        <p class="text-muted mb-0">3274 Lyndon Street</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$940.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#8943</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/19.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Jacqueline Rios</h5>
                                        <p class="text-muted mb-0">559 Holly Street</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$490.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#8943</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/01.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Samuel Hayes</h5>
                                        <p class="text-muted mb-0">716 Riverwood Drive</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$230.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#2357</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/15.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Tyler Hamilton</h5>
                                        <p class="text-muted mb-0">1979 Monroe Street</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$319.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#5784</td>
                            <td>
                                <div class="media">
                                    <div class="media-left avatar"><img src="/system/assets/images/users/16.jpg" alt="" class="media-object img-circle"><span class="status bg-success"></span></div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Lawrence Castillo</h5>
                                        <p class="text-muted mb-0">1704 Saints Alley</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-center">20 Jun 2016</td>
                            <td class="text-right">$860.00</td>
                            <td class="text-center"><span class="label label-warning">Pending</span></td>
                            <td class="text-center">
                                <div role="group" aria-label="Basic example" class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline btn-primary"><i class="ti-eye"></i></button>
                                    <button type="button" class="btn btn-outline btn-success"><i class="ti-pencil"></i></button>
                                    <button type="button" class="btn btn-outline btn-danger"><i class="ti-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script type="text/javascript" src="/system/assets/js/page-content/dashboard/index-v2.js"></script>
@endpush