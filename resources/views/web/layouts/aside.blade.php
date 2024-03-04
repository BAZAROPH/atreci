@mobile
<!-- Sidebar menu-->
<aside class="cz-sidebar cz-sidebar-fixed" id="sideNav" style="padding-top: 5rem;">
    <button class="close" type="button" data-dismiss="sidebar" aria-label="Close">
        <span class="d-inline-block font-size-xs font-weight-normal align-middle">Fermer</span>
        <span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
    </button>
    <div class="cz-sidebar-inner">
        <ul class="nav nav-tabs nav-justified mt-2 mt-lg-4 mb-0" role="tablist" style="min-height: 3rem;">
            <li class="nav-item">
                <a class="nav-link font-weight-medium active" href="#categories" data-toggle="tab" role="tab">Categories</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link font-weight-medium" href="#menu" data-toggle="tab" role="tab">Menu</a>
            </li> --}}
        </ul>
        <div class="cz-sidebar-body pt-3 pb-0" data-simplebar>
            <div class="tab-content">
                <!-- Categories-->
                <div class="sidebar-nav tab-pane fade show active" id="categories" role="tabpanel">
                    <div class="widget widget-categories">
                        <div class="accordion" id="shop-categories">
                            <!-- Special offers-->
                            <div class="card border-bottom">
                                <div class="card-header">
                                    <h3 class="accordion-heading font-size-base px-grid-gutter">
                                        <a class="collapsed py-3" href="#">
                                            <span class="d-flex align-items-center">
                                                <i class="czi-discount font-size-lg text-danger mt-n1 mr-2"></i>
                                                Offres spéciales
                                            </span>
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            @foreach ($categorieEcommerce->first()->childrens as $item)
                                <div class="card border-bottom">
                                    <div class="card-header">
                                        <h3 class="accordion-heading font-size-base px-grid-gutter">
                                            <a class="collapsed py-3" href="#{{ $item->slug }}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="bakery">
                                                <span class="d-flex align-items-center">
                                                    <i class="{{ $item->icon }} font-size-lg opacity-60 mt-n1 mr-2"></i>
                                                    {{ $item->libelle }}
                                                </span>
                                                <span class="accordion-indicator"></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div class="collapse" id="{{ $item->slug }}" data-parent="#shop-categories">
                                        <div class="card-body px-grid-gutter pb-4">
                                            <div class="widget widget-links">
                                                <ul class="widget-list">
                                                    <li class="widget-list-item">
                                                        <a class="widget-list-link" href="{{ urlMode(url('category/'.$item->slug), $parametre->type_id) }}">
                                                            Voir tous
                                                        </a>
                                                    </li>
                                                    @php($i = 0)
                                                    @foreach ($item->childrens as $valeur)
                                                        @php($i++)
                                                        <li class="widget-list-item">
                                                            <a class="widget-list-link" href="{{ urlMode(url('category/'.$valeur->slug), $parametre->type_id) }}">
                                                                {{ $valeur->libelle }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Fruits and Vegetables-->
                            {{-- <div class="card border-bottom">
                                <div class="card-header">
                                    <h3 class="accordion-heading font-size-base px-grid-gutter"><a class="collapsed py-3" href="#fruits" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="fruits"><span class="d-flex align-items-center"><i class="czi-apple font-size-lg opacity-60 mt-n1 mr-2"></i>Fruits and Vegetables</span><span class="accordion-indicator"></span></a></h3>
                                </div>
                                <div class="collapse" id="fruits" data-parent="#shop-categories">
                                    <div class="card-body px-grid-gutter pb-4">
                                    <div class="widget widget-links">
                                        <ul class="widget-list">
                                        <li class="widget-list-item"><a class="widget-list-link" href="#">View all</a></li>
                                        <li class="widget-list-item"><a class="widget-list-link" href="#">Fruits</a>
                                            <ul class="widget-list pt-1">
                                            <li class="widget-list-item"><a class="widget-list-link" href="#">Pears, apples, quinces</a></li>
                                            <li class="widget-list-item"><a class="widget-list-link" href="#">Bananas, pineapples, kiwi</a></li>
                                            <li class="widget-list-item"><a class="widget-list-link" href="#">Citrus</a></li>
                                            <li class="widget-list-item"><a class="widget-list-link" href="#">Peaches, plums, apricots</a></li>
                                            <li class="widget-list-item"><a class="widget-list-link" href="#">Grapes</a></li>
                                            <li class="widget-list-item"><a class="widget-list-link" href="#">Exotic fruits</a></li>
                                            <li class="widget-list-item"><a class="widget-list-link" href="#">Berries</a></li>
                                            </ul>
                                        </li>
                                        <li class="widget-list-item"><a class="widget-list-link" href="#">Vegetables</a></li>
                                        <li class="widget-list-item"><a class="widget-list-link" href="#">Mushrooms</a></li>
                                        <li class="widget-list-item"><a class="widget-list-link" href="#">Fresh greens</a></li>
                                        <li class="widget-list-item"><a class="widget-list-link" href="#">Dried fruits</a></li>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- Menu-->
                {{-- <div class="sidebar-nav tab-pane fade" id="menu" role="tabpanel">
                    <div class="widget widget-categories">
                    <div class="accordion" id="shop-menu">
                        <!-- Homepages-->
                        <div class="card border-bottom">
                        <div class="card-header">
                            <h3 class="accordion-heading font-size-base px-grid-gutter"><a class="collapsed py-3" href="#home" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="home">Homepages<span class="accordion-indicator"></span></a></h3>
                        </div>
                        <div class="collapse" id="home" data-parent="#shop-menu">
                            <div class="card-body px-grid-gutter pb-4">
                            <div class="widget widget-links">
                                <ul class="widget-list">
                                <li class="widget-list-item"><a class="widget-list-link" href="home-fashion-store-v1.html">Fashion Store v.1</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="home-electronics-store.html">Electronics Store</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="home-marketplace.html">Multi-vendor Marketplace</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="home-grocery-store.html">Grocery Store</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="home-food-delivery.html">Food Delivery Service</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="home-fashion-store-v2.html">Fashion Store v.2</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="home-single-store.html">Single Product/Brand Store</a></li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Shop-->
                        <div class="card border-bottom">
                        <div class="card-header">
                            <h3 class="accordion-heading font-size-base px-grid-gutter"><a class="collapsed py-3" href="#shop" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="shop">Shop<span class="accordion-indicator"></span></a></h3>
                        </div>
                        <div class="collapse" id="shop" data-parent="#shop-menu">
                            <div class="card-body px-grid-gutter pb-4">
                            <div class="widget widget-links">
                                <ul class="widget-list">
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Shop Layouts</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-grid-ls.html">Shop Grid - Left Sidebar</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-grid-rs.html">Shop Grid - Right Sidebar</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-grid-ft.html">Shop Grid - Filters on Top</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-list-ls.html">Shop List - Left Sidebar</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-list-rs.html">Shop List - Right Sidebar</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-list-ft.html">Shop List - Filters on Top</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Marketplace</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="marketplace-category.html">Category Page</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="marketplace-single.html">Single Item Page</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="marketplace-vendor.html">Vendor Page</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="marketplace-cart.html">Cart</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="marketplace-checkout.html">Checkout</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Grocery Store</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="grocery-catalog.html">Product Catalog</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="grocery-single.html">Single Product Page</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="grocery-checkout.html">Checkout</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Food Delivery</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="food-delivery-category.html">Category Page</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="food-delivery-single.html">Single Item (Restaurant)</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="food-delivery-cart.html">Cart (Your Order)</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="food-delivery-checkout.html">Checkout (Address &amp; Payment)</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Shop pages</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-categories.html">Shop Categories</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-single-v1.html">Product Page v.1</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-single-v2.html">Product Page v.2</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="shop-cart.html">Cart</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="checkout-details.html">Checkout - Details</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="checkout-shipping.html">Checkout - Shipping</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="checkout-payment.html">Checkout - Payment</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="checkout-review.html">Checkout - Review</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="checkout-complete.html">Checkout - Complete</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="order-tracking.html">Order Tracking</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="comparison.html">Product Comparison</a></li>
                                    </ul>
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Account-->
                        <div class="card border-bottom">
                        <div class="card-header">
                            <h3 class="accordion-heading font-size-base px-grid-gutter"><a class="collapsed py-3" href="#account" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="account">Account<span class="accordion-indicator"></span></a></h3>
                        </div>
                        <div class="collapse" id="account" data-parent="#shop-menu">
                            <div class="card-body px-grid-gutter pb-4">
                            <div class="widget widget-links">
                                <ul class="widget-list">
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Shop User Account</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="account-orders.html">Orders History</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="account-profile.html">Profile Settings</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="account-address.html">Account Addresses</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="account-payment.html">Payment Methods</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="account-wishlist.html">Wishlist</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="account-tickets.html">My Tickets</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="account-single-ticket.html">Single Ticket</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Vendor Dashboard</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="dashboard-settings.html">Settings</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="dashboard-purchases.html">Purchases</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="dashboard-favorites.html">Favorites</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="dashboard-sales.html">Sales</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="dashboard-products.html">Products</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="dashboard-add-new-product.html">Add New Product</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="dashboard-payouts.html">Payouts</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link" href="account-signin.html">Sign In / Sign Up</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="account-password-recovery.html">Password Recovery</a></li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Pages-->
                        <div class="card border-bottom">
                        <div class="card-header">
                            <h3 class="accordion-heading font-size-base px-grid-gutter"><a class="collapsed py-3" href="#pages" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="pages">Pages<span class="accordion-indicator"></span></a></h3>
                        </div>
                        <div class="collapse" id="pages" data-parent="#shop-menu">
                            <div class="card-body px-grid-gutter pb-4">
                            <div class="widget widget-links">
                                <ul class="widget-list">
                                <li class="widget-list-item"><a class="widget-list-link" href="about.html">About Us</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="contacts.html">Contacts</a></li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Help Center</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="help-topics.html">Help Topics</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="help-single-topic.html">Single Topic</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="help-submit-request.html">Submit a Request</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">404 Not Found</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="404-simple.html">404 - Simple Text</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="404-illustration.html">404 - Illustration</a></li>
                                    </ul>
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Blog-->
                        <div class="card border-bottom">
                        <div class="card-header">
                            <h3 class="accordion-heading font-size-base px-grid-gutter"><a class="collapsed py-3" href="#blog" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="blog">Blog<span class="accordion-indicator"></span></a></h3>
                        </div>
                        <div class="collapse" id="blog" data-parent="#shop-menu">
                            <div class="card-body px-grid-gutter pb-4">
                            <div class="widget widget-links">
                                <ul class="widget-list">
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Blog List Layouts</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="blog-list-sidebar.html">List with Sidebar</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="blog-list.html">List no Sidebar</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Blog Grid Layouts</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="blog-grid-sidebar.html">Grid with Sidebar</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="blog-grid.html">Grid no Sidebar</a></li>
                                    </ul>
                                </li>
                                <li class="widget-list-item"><a class="widget-list-link font-weight-medium" href="#">Single Post Layouts</a>
                                    <ul class="widget-list pt-1">
                                    <li class="widget-list-item"><a class="widget-list-link" href="blog-single-sidebar.html">Article with Sidebar</a></li>
                                    <li class="widget-list-item"><a class="widget-list-link" href="blog-single.html">Article no Sidebar</a></li>
                                    </ul>
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Docs-->
                        <div class="card border-bottom">
                        <div class="card-header">
                            <h3 class="accordion-heading font-size-base px-grid-gutter"><a class="collapsed py-3" href="#docs" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="docs">Docs / Components<span class="accordion-indicator"></span></a></h3>
                        </div>
                        <div class="collapse" id="docs" data-parent="#shop-menu">
                            <div class="card-body px-grid-gutter pb-4">
                            <div class="widget widget-links">
                                <ul class="widget-list">
                                <li class="widget-list-item"><a class="widget-list-link" href="docs/dev-setup.html">Documentation</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="components/typography.html">Components</a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="docs/changelog.html">Changelog<span class="badge badge-success ml-2">v1.4</span></a></li>
                                <li class="widget-list-item"><a class="widget-list-link" href="mailto:contact@createx.studio">Support</a></li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="px-grid-gutter pt-5 pb-4 mb-2">
            <div class="d-flex mb-3">
                <i class="czi-support h4 mb-0 font-weight-normal text-primary mt-1 mr-1"></i>
                <div class="pl-2">
                    <div class="text-muted font-size-sm">Support</div>
                    <a class="nav-link-style font-size-md" href="tel:+0709096551">
                        (+225) 07 09 09 65 51
                    </a>
                </div>
            </div>
            <div class="d-flex mb-3">
                <i class="czi-mail h5 mb-0 font-weight-normal text-primary mt-1 mr-1"></i>
                <div class="pl-2">
                    <div class="text-muted font-size-sm">Email</div>
                    <a class="nav-link-style font-size-md" href="mailto:info@atre.ci">
                        info@atre.ci
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside>
@endmobile()
