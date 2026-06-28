<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    @yield('meta')
    @stack('css')

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->favicon()]) }}" type="image/x-icon">
    <link rel="icon" href="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->favicon()]) }}" type="image/x-icon">

    <!-- Web Fonts -->
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/animate/animate.compat.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/owl.carousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/magnific-popup/magnific-popup.min.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme-shop.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/skins/skin-medical.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

    <!-- Analytics -->
    @if(!empty($ws->google_analytics_code)){!! $ws->google_analytics_code !!}@endif
    @if(!empty($ws->google_search_console)){!! $ws->google_search_console !!}@endif
    @if(!empty($ws->facebook_pixel_code)){!! $ws->facebook_pixel_code !!}@endif

    <style>
        /* ================= Floating Desktop Cart ================= */
        .envato-buy-redirect {
            position: fixed;
            top: 45%;
            right: 20px;
            z-index: 9999;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 2px solid #FF1493;
        }
        .envato-buy-redirect:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
        }
        .envato-buy-redirect i {
            font-size: 28px;
            color: #FF1493;
        }
        .extra-cart-info {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #FF1493;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ================= Floating WhatsApp ================= */
        .floating-message-icon {
            position: fixed;
            top: calc(45% + 80px);
            right: 20px;
            z-index: 9999;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #25D366;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease;
        }
        .floating-message-icon:hover {
            transform: scale(1.1);
        }
        .floating-message-icon img {
            width: 38px;
            height: 38px;
        }

        /* ================= Mobile Bottom Bar ================= */
        .mobile-bottom-bar {
            display: none;
        }
        @media (max-width: 768px) {
            /* .envato-buy-redirect, .floating-message-icon {
                display: none !important;
            } */
            .mobile-bottom-bar {
                display: flex !important;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 60px;
                align-items: center;
                justify-content: space-between;
                background: #ffffff;
                box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
                padding: 0 10px;
                z-index: 9999;
            }
            .checkout-btn {
                background: #0A52A3;
                color: #fff;
                font-weight: bold;
                padding: 6px 36px;
                border-radius: 10px;
                text-decoration: none;
                display: flex;
                align-items: center;
                position: relative;
            }
            .checkout-price {
                position: absolute;
                top: -6px;
                right: -8px;
                background: red;
                color: #fff;
                font-size: 12px;
                padding: 2px 6px;
                border-radius: 50%;
            }
            .other-icons {
                display: flex;
                gap: 15px;
            }
            .other-icons a {
                color: #0A52A3;
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
@php 
$count_info = \App\Models\Cart::when(Auth::check(), fn($q) => $q->where('user_id', Auth::id()))
    ->when(!Auth::check(), fn($q) => $q->where('session_id', session('session_id')));
$count_data = $count_info->count();
$totalCartPrice = \App\Models\Cart::totalCartPrice();
@endphp

<div class="body">
    @include('frontend.layouts.ecommerceheader')

    <div role="main" class="main mt-5">

        <!-- 🛒 Floating Add to Cart Button -->
        <a class="envato-buy-redirect" href="{{ route('new.checkout') }}">
            <i class="fas fa-shopping-cart"></i>
            <span class="extra-cart-info"><span class="cartItemsCount">{{ $count_data }}</span></span>
        </a>

        <!-- 📱 Mobile Bottom Navigation Bar -->
        <div class="mobile-bottom-bar">
            <a href="{{ route('checkout') }}" class="checkout-btn">
                Checkout
                <span class="checkout-price">৳{{ $totalCartPrice }}</span>
                <i class="fas fa-shopping-cart ms-2"></i>
            </a>
            <div class="other-icons">
                <a href="{{ url('/') }}"><i class="fas fa-home"></i></a>
                <a href="{{ url('/') }}"><i class="fas fa-th-large"></i></a>
                <a href="#" class="mobile-search-trigger"><i class="fas fa-search"></i></a>
            </div>
        </div>

        <!-- ✅ Sweet Alert & Content -->
        @include('sweetalert::alert')
        @yield('content')
    </div>

    @include('frontend.layouts.footer')
</div>

<!-- ================= Scripts ================= -->
<script src="{{ asset('frontend/assets/vendor/plugins/js/plugins.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/theme.js') }}"></script>
<script src="{{ asset('frontend/assets/js/views/view.contact.js') }}"></script>
<script src="{{ asset('frontend/assets/js/demos/demo-medical.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
<script src="{{ asset('frontend/assets/js/theme.init.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@stack('js')

<script>
		$.ajaxSetup({
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
		});

		$(document).ready(function () {

			$('#searchIcon').on('click', function(e) {
				e.preventDefault();
				$('#searchContainer').toggle();
			});


			// Add to Cart
			$(document).on("click", ".addToCart", function () {
				let btn = $(this);
				let url = btn.data("url");
				let product_id = btn.data("product");
				let qty = parseInt(btn.closest(".productCartItem").find(".product_qty").val()) || 1;

				$.post(url, { product: product_id, qty: qty }, function (res) {
					if (res.status) {
						btn.closest(".productCartItem").html(res.productCartItem);
						$(".cartCount").text(res.cartCount);
						$(".cartItemsCount").text(res.cartItemsCount);
						$(".cartTotalPrice").text(res.cartTotal.toFixed(2) + " tk");
						$(".mobileCartTotalPrice").text("৳" + res.cartTotal.toFixed(2));

						Swal.fire({
							toast: true, icon: "success", title: res.message,
							position: "top", timer: 2000, showConfirmButton: false
						});
					}
				}).fail(() => {
					Swal.fire("Error", "Could not add to cart.", "error");
				});
			});
			

			$(document).on('click', '.updateCartItemold', function (e) {
				e.preventDefault();

				let $btn = $(this);
				let cartId = $btn.data('cart');
				let url = $btn.data('url');
				let $wrapper = $btn.closest('.cart-action-wrapper');
				let qty = parseInt($wrapper.find('.cartQtyDisplay').text()) || 0;

				// Update quantity
				if ($btn.hasClass('plus')) {
					qty++;
				} else if ($btn.hasClass('minus')) {
					qty--;
					if (qty < 0) qty = 0; // prevent negative qty
				}

				// Disable button during AJAX
				$btn.prop('disabled', true);

				$.ajax({
					url: url,
					method: 'POST',
					data: {
						cart: cartId,
						new_qty: qty,
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					success: function (res) {
						if (res.status) {
							if (qty === 0) {
								// Replace qty box with "Add to Cart"
								$wrapper.html(`
									<input type="hidden" name="product_qty" value="1" class="product_qty">
									<button class="btn btn-outline-primary w-100 btn-sm addToCart"
										data-url="${res.add_to_cart_url}"
										data-product="${res.product_id}">
										ADD TO CART
									</button>
								`);

								// If no cart items left → redirect

							
								if ($(".cart-item").length === 0) {
									window.location.href = "/";
								}
							} else {
								// Update qty display & button data
								$wrapper.find('.cartQtyDisplay').text(qty);
								$wrapper.find('.plus').data('qty', qty);
								$wrapper.find('.minus').data('qty', qty);

								// Update row subtotal
								let $row = $btn.closest('.cart-item');
								let $priceBox = $row.find('.itemTotalPrice');
								if ($priceBox.length) {
									let unitPrice = parseFloat($priceBox.data('unit-price'));
									$priceBox.text("Tk. " + (unitPrice * qty).toFixed(2));
								}
							}

							                            // Update header/cart summary
														$('.cartCount').text(res.cartCount);
														$('.cartItemsCount').text(res.cartItemsCount);
							
														$(".subtotal").text("Tk. " + res.cartTotal.toFixed(2));
														$(".discount").text("-Tk. " + res.discount.toFixed(2));
														$(".payable").text("Tk. " + res.payable.toFixed(2));
														$(".mobileCartTotalPrice").text('৳' + res.payable.toFixed(2));
													}
												},
												error: function () {						alert('Something went wrong! Please try again.');
					},
					complete: function () {
						$btn.prop('disabled', false);
					}
				});
			});


			$(document).on('click', '.updateCartItem', function (e) {
				e.preventDefault();

				let $btn = $(this);
				let cartId = $btn.data('cart');
				let url = $btn.data('url');
				let $wrapper = $btn.closest('.cart-action-wrapper');
				let qty = parseInt($wrapper.find('.cartQtyDisplay').text()) || 0;

				// Qty update
				if ($btn.hasClass('plus')) {
					qty++;
				} else if ($btn.hasClass('minus')) {
					qty--;
					if (qty < 0) qty = 0; // negative prevent
				}

				$btn.prop('disabled', true); // prevent double click

				$.ajax({
					url: url,
					method: 'POST',
					data: {
						cart: cartId,
						new_qty: qty,
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					success: function (res) {
						if (res.status) {
							if (qty === 0) {
								// Show Add to Cart
								$wrapper.html(`
									<input type="hidden" name="product_qty" value="1" class="product_qty">
									<button class="btn btn-outline-primary w-100 btn-sm addToCart"
										data-url="${res.add_to_cart_url}"
										data-product="${res.product_id}">
										ADD TO CART
									</button>
								`);

								if ($(".cart-item").length === 0) {
									window.location.href = "/";
								}
							} else {
								// Update qty display
								$wrapper.find('.cartQtyDisplay').text(qty);
								$wrapper.find('.plus').data('qty', qty);
								$wrapper.find('.minus').data('qty', qty);

								// ✅ Row subtotal update (cart page)
								let $row = $btn.closest('.cart-item');
								let $priceBox = $row.find('.itemTotalPrice');
								if ($priceBox.length) {
									let unitPrice = parseFloat($priceBox.data('unit-price'));
									$priceBox.text("Tk. " + (unitPrice * qty).toFixed(2));
								}

								// ✅ Product details price update
								updateProductDetailsPrice(qty);
							}

							// ✅ Header/cart summary update
							$('.cartCount').text(res.cartCount);
							$('.cartItemsCount').text(res.cartItemsCount);
							$(".subtotal").text("Tk. " + res.cartTotal.toFixed(2));
							$(".discount").text("-Tk. " + res.discount.toFixed(2));
							$(".payable").text("Tk. " + res.payable.toFixed(2));
							$(".mobileCartTotalPrice").text('৳' + res.payable.toFixed(2));
						}
					},
					error: function () {
						alert('Something went wrong! Please try again.');
					},
					complete: function () {
						$btn.prop('disabled', false);
					}
				});
			});

			/**
			 * ✅ Update product details page price dynamically
			 */
			function updateProductDetailsPrice(qty) {
				let unitPriceBox = $('.unitPriceBox');
				let finalPriceBox = $('.finalPriceBox');

				if (finalPriceBox.length) {
					let unitFinal = parseFloat(finalPriceBox.data('unit-price'));
					finalPriceBox.text((unitFinal * qty).toFixed(2) + " ৳");
				}
				if (unitPriceBox.length) {
					let unitStrike = parseFloat(unitPriceBox.data('unit-price'));
					unitPriceBox.text((unitStrike * qty).toFixed(2) + " ৳");
				}
			}

			



			// Delete Cart Item
			$(document).on("click", ".deleteCartItem", function () {
				let btn = $(this);
				$.post(btn.data("url"), {}, function (res) {
					if (res.status) {
						$('.cart-item[data-cart="' + res.cart_id + '"]').remove();

						if ($(".cart-item").length === 0) {
							window.location.href = "/";
						}

						$(".cartCount").text(res.cartCount);
						$(".cartItemsCount").text(res.cartItemsCount);
						$(".cartTotalPrice").text(res.cartTotal.toFixed(2) + " tk");
						$(".subtotal").text("Tk. " + res.cartTotal.toFixed(2)).attr('data-value', res.cartTotal);
						$(".discount").text("-Tk. " + res.discount.toFixed(2)).attr('data-value', res.discount);
						$(".payable").text("Tk. " + res.payable.toFixed(2));
						$(".mobileCartTotalPrice").text('৳' + res.payable.toFixed(2));

						Swal.fire({
							toast: true, icon: "success", title: res.message,
							position: "top-end", timer: 2000, showConfirmButton: false
						});
					}
				}).fail(() => {
					Swal.fire("Error", "Cart item could not be removed.", "error");
				});
			});

		});
		</script>

<!-- ✅ Floating WhatsApp Icon -->
<a class="floating-message-icon" href="https://wa.me/8801334927985?text=Hello%20there!" target="_blank">
    <img src="{{ asset('frontend/assets/img/icons/whatsapp.svg') }}" alt="WhatsApp">
</a>

<!-- ============================================================
     DESKTOP SEARCH OVERLAY
============================================================ -->
<div id="desktopSearchOverlay">
    <div id="desktopSearchBox">
        <div class="dso-input-wrap">
            <i class="fas fa-search dso-icon"></i>
            <input type="text" id="desktopSearchInput" placeholder="Search products…" autocomplete="off">
            <button id="desktopSearchClose"><i class="fas fa-times"></i></button>
        </div>
        <div id="desktopSearchResults"></div>
    </div>
</div>

<!-- ============================================================
     MOBILE SEARCH DRAWER (right → left)
============================================================ -->
<div id="mobileSearchBackdrop"></div>
<div id="mobileSearchDrawer">
    <div class="msd-header">
        <span class="msd-title">Search Products</span>
        <button id="mobileSearchClose"><i class="fas fa-times"></i></button>
    </div>
    <div class="msd-input-wrap">
        <i class="fas fa-search msd-icon"></i>
        <input type="text" id="mobileSearchInput" placeholder="Search products…" autocomplete="off">
    </div>
    <div id="mobileSearchResults"></div>
</div>

<style>
/* ============================================================
   DESKTOP SEARCH OVERLAY
============================================================ */
#desktopSearchOverlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.55);
    z-index: 99999;
    align-items: flex-start;
    justify-content: center;
    padding-top: 80px;
}
#desktopSearchOverlay.active { display: flex; }

#desktopSearchBox {
    background: #fff;
    border-radius: 12px;
    width: 680px;
    max-width: 95vw;
    box-shadow: 0 8px 40px rgba(0,0,0,0.22);
    overflow: hidden;
}

.dso-input-wrap {
    display: flex;
    align-items: center;
    padding: 14px 18px;
    border-bottom: 1px solid #eee;
    gap: 10px;
}
.dso-icon { color: #999; font-size: 16px; }
#desktopSearchInput {
    flex: 1;
    border: none;
    outline: none;
    font-size: 17px;
    color: #333;
    background: transparent;
}
#desktopSearchInput::placeholder { color: #bbb; }
#desktopSearchClose {
    background: none;
    border: none;
    cursor: pointer;
    color: #999;
    font-size: 18px;
    padding: 4px 6px;
    line-height: 1;
    transition: color .2s;
}
#desktopSearchClose:hover { color: #333; }

#desktopSearchResults {
    max-height: 420px;
    overflow-y: auto;
    padding: 8px 0;
}

/* ============================================================
   MOBILE SEARCH DRAWER
============================================================ */
#mobileSearchBackdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 99998;
}
#mobileSearchBackdrop.active { display: block; }

#mobileSearchDrawer {
    position: fixed;
    top: 0; right: -100%;
    width: 88%;
    max-width: 400px;
    height: 100%;
    background: #fff;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    transition: right .3s cubic-bezier(.4,0,.2,1);
    box-shadow: -4px 0 24px rgba(0,0,0,0.18);
}
#mobileSearchDrawer.open { right: 0; }

.msd-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px;
    border-bottom: 1px solid #eee;
    background: #f8f9fa;
}
.msd-title { font-weight: 600; font-size: 16px; color: #333; }
#mobileSearchClose {
    background: none;
    border: none;
    cursor: pointer;
    color: #666;
    font-size: 18px;
    padding: 4px 6px;
    line-height: 1;
}

.msd-input-wrap {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #eee;
    gap: 10px;
}
.msd-icon { color: #999; font-size: 15px; }
#mobileSearchInput {
    flex: 1;
    border: none;
    outline: none;
    font-size: 15px;
    color: #333;
    background: transparent;
}

#mobileSearchResults {
    flex: 1;
    overflow-y: auto;
    padding: 8px 0;
}

/* ============================================================
   SHARED: SEARCH RESULT CARDS
============================================================ */
.search-result-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border-bottom: 1px solid #f2f2f2;
    transition: background .15s;
}
.search-result-item:last-child { border-bottom: none; }
.search-result-item:hover { background: #f8f9fb; }

.sri-img {
    width: 58px;
    height: 58px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
    border: 1px solid #eee;
}

.sri-info {
    flex: 1;
    min-width: 0;
}
.sri-name {
    font-size: 14px;
    font-weight: 500;
    color: #222;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-decoration: none;
    display: block;
    line-height: 1.3;
    margin-bottom: 4px;
}
.sri-name:hover { color: #0A52A3; }
.sri-price { font-size: 13px; }
.sri-price-final { color: #0A52A3; font-weight: 600; }
.sri-price-original { color: #aaa; text-decoration: line-through; margin-left: 5px; font-size: 12px; }

.sri-btn {
    flex-shrink: 0;
    font-size: 12px;
    padding: 6px 12px;
    border-radius: 6px;
    background: #0A52A3;
    color: #fff;
    border: none;
    cursor: pointer;
    white-space: nowrap;
    transition: background .2s;
}
.sri-btn:hover { background: #083d80; }
.sri-btn.added { background: #28a745; }

.search-no-results, .search-loading {
    padding: 24px 16px;
    text-align: center;
    color: #888;
    font-size: 14px;
}
.search-loading i { animation: spin .8s linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }

.search-view-all {
    display: block;
    text-align: center;
    padding: 12px;
    font-size: 13px;
    color: #0A52A3;
    text-decoration: none;
    border-top: 1px solid #eee;
    font-weight: 500;
}
.search-view-all:hover { background: #f0f5ff; }
</style>

<script>
(function () {
    const SEARCH_URL = '{{ route("liveProductSearch") }}';
    const CSRF      = $('meta[name="csrf-token"]').attr('content');

    /* ---- Utilities ---- */
    function debounce(fn, delay) {
        let t;
        return function (...args) { clearTimeout(t); t = setTimeout(() => fn.apply(this, args), delay); };
    }

    function buildResultsHTML(products, query) {
        if (!products.length) {
            return '<div class="search-no-results">No products found for <strong>"' + $('<span>').text(query).html() + '"</strong></div>';
        }

        let html = '';
        products.forEach(function (p) {
            const name = $('<span>').text(p.name).html();
            const finalPrice = parseFloat(p.final_price) || parseFloat(p.selling_price) || 0;
            const origPrice  = parseFloat(p.selling_price) || 0;
            const hasDiscount = p.discount > 0;

            let priceHtml = '<span class="sri-price-final">৳' + finalPrice.toFixed(2) + '</span>';
            if (hasDiscount) {
                priceHtml += '<span class="sri-price-original">৳' + origPrice.toFixed(2) + '</span>';
            }

            html += `
            <div class="search-result-item productCartItem">
                <a href="${p.url}">
                    <img class="sri-img" src="${p.image}" alt="${name}" onerror="this.src='{{ asset('frontend/assets/img/placeholder.jpg') }}'">
                </a>
                <div class="sri-info">
                    <a href="${p.url}" class="sri-name">${name}</a>
                    <div class="sri-price">${priceHtml}</div>
                </div>
                <input type="hidden" class="product_qty" value="1">
                <button class="sri-btn addToCart"
                    data-url="${p.add_to_cart_url}"
                    data-product="${p.id}"
                    ${!p.in_stock ? 'disabled title="Out of stock"' : ''}>
                    ${p.in_stock ? '<i class="fas fa-cart-plus me-1"></i>Add' : 'Out of stock'}
                </button>
            </div>`;
        });

        html += `<a class="search-view-all" href="{{ route('search') }}?q=${encodeURIComponent(query)}">View all results <i class="fas fa-arrow-right ms-1"></i></a>`;
        return html;
    }

    function fetchResults(query, $container) {
        if (query.length < 1) { $container.html(''); return; }

        $container.html('<div class="search-loading"><i class="fas fa-spinner me-2"></i>Searching…</div>');

        $.get(SEARCH_URL, { q: query }, function (data) {
            $container.html(buildResultsHTML(data, query));
        }).fail(function () {
            $container.html('<div class="search-no-results">Search failed. Please try again.</div>');
        });
    }

    const debouncedFetch = debounce(fetchResults, 280);

    /* ---- Desktop overlay ---- */
    const $overlay     = $('#desktopSearchOverlay');
    const $dInput      = $('#desktopSearchInput');
    const $dResults    = $('#desktopSearchResults');

    $('#desktopSearchToggle').on('click', function () {
        $overlay.addClass('active');
        setTimeout(function () { $dInput.focus(); }, 80);
    });

    $('#desktopSearchClose').on('click', function () {
        $overlay.removeClass('active');
        $dInput.val('');
        $dResults.html('');
    });

    $overlay.on('click', function (e) {
        if (!$(e.target).closest('#desktopSearchBox').length) {
            $overlay.removeClass('active');
            $dInput.val('');
            $dResults.html('');
        }
    });

    $dInput.on('input', function () {
        debouncedFetch($(this).val().trim(), $dResults);
    });

    /* ---- Mobile drawer ---- */
    const $drawer   = $('#mobileSearchDrawer');
    const $backdrop = $('#mobileSearchBackdrop');
    const $mInput   = $('#mobileSearchInput');
    const $mResults = $('#mobileSearchResults');

    function openMobileDrawer() {
        $drawer.addClass('open');
        $backdrop.addClass('active');
        $('body').css('overflow', 'hidden');
        setTimeout(function () { $mInput.focus(); }, 320);
    }

    function closeMobileDrawer() {
        $drawer.removeClass('open');
        $backdrop.removeClass('active');
        $('body').css('overflow', '');
        $mInput.val('');
        $mResults.html('');
    }

    // Mobile bottom bar search icon
    $(document).on('click', '.mobile-search-trigger, [data-search-open]', function (e) {
        e.preventDefault();
        openMobileDrawer();
    });

    $('#mobileSearchClose').on('click', closeMobileDrawer);
    $backdrop.on('click', closeMobileDrawer);

    $mInput.on('input', function () {
        debouncedFetch($(this).val().trim(), $mResults);
    });

    // Keyboard: Esc to close both
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $overlay.removeClass('active');
            closeMobileDrawer();
        }
    });

    // After addToCart success — visually mark the button as added
    $(document).on('click', '.sri-btn.addToCart', function () {
        const $btn = $(this);
        $btn.html('<i class="fas fa-check me-1"></i>Added').addClass('added').prop('disabled', true);
        setTimeout(function () {
            $btn.html('<i class="fas fa-cart-plus me-1"></i>Add').removeClass('added').prop('disabled', false);
        }, 2200);
    });
})();
</script>

</body>
</html>
