<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{url('/')}}"><img src="{{env('SSO_URL').'/storage/'.setting('site_logo')}}" alt="Logo" style="height: 1.5em; border-radius:10px; object-fit:contain;"></a>
                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                        role="img" class="iconify iconify--system-uicons" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                        role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li
                    class="sidebar-item {{Route::is('home') || Route::is('dashboard') ? 'active' : ''}}">
                    <a href="{{url('/')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-title text-secondary">Management</li>
                {{-- <li
                    class="sidebar-item {{Route::is('application*') ? 'active' : ''}}">
                    <a href="" class='sidebar-link'>
                        <i class="bi bi-box-seam-fill"></i>
                        <span>Product</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{Route::is('application*') ? 'active' : ''}}">
                    <a href="" class='sidebar-link'>
                        <i class="bi bi-person-square"></i>
                        <span>Principle</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{Route::is('application*') ? 'active' : ''}}">
                    <a href="" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Client</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{Route::is('application*') ? 'active' : ''}}">
                    <a href="" class='sidebar-link'>
                        <i class="bi bi-truck-flatbed"></i>
                        <span>Logistic</span>
                    </a>
                </li> --}}
                <li
                    class="sidebar-item has-sub {{Route::is('product*') || Route::is('satuan*') || Route::is('packaging*') ? 'active' : ''}}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-bag-fill"></i>
                        <span>Products</span>
                    </a>
                    
                    <ul class="submenu ">
                        <li class="submenu-item  ">
                            <a href="{{route('product.index')}}" class="submenu-link">Product</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('satuan.index')}}" class="submenu-link">Satuan</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('packaging.index')}}" class="submenu-link">Packaging</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item {{Route::is('principle*') ? 'active' : ''}}">
                    <a href="{{route('principle.index')}}" class='sidebar-link'>
                        <i class="bi bi-person-vcard"></i>
                        <span>Principle</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{Route::is('client*') ? 'active' : ''}}">
                    <a href="{{route('client.index')}}" class='sidebar-link'>
                        <i class="bi bi-person-square"></i>
                        <span>Client</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{Route::is('logistic*') ? 'active' : ''}}">
                    <a href="{{route('logistic.index')}}" class='sidebar-link'>
                        <i class="bi bi-truck"></i>
                        <span>Logistic</span>
                    </a>
                </li>
                <li class="sidebar-title text-secondary">Business Process</li>
                <li
                    class="sidebar-item {{Route::is('quotation*') ? 'active' : ''}}">
                    <a href="{{route('quotation.index')}}" class='sidebar-link'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M483.82 32.45a16.28 16.28 0 0 0-11.23 1.37L448 46.1l-24.8-12.4a16 16 0 0 0-14.31 0l-25.11 12.41L359 33.7a16 16 0 0 0-14.36 0L320 46.07l-24.45-12.34a16 16 0 0 0-14.35-.06L256 46.12l-24.8-12.43a16.05 16.05 0 0 0-14.33 0L192 46.1l-24.84-12.41a16 16 0 0 0-19.36 3.94a16.25 16.25 0 0 0-3.8 10.65V288l.05.05H336a32 32 0 0 1 32 32V424c0 30.93 33.07 56 64 56h12a52 52 0 0 0 52-52V48a16 16 0 0 0-12.18-15.55M416 240H288.5c-8.64 0-16.1-6.64-16.48-15.28A16 16 0 0 1 288 208h127.5c8.64 0 16.1 6.64 16.48 15.28A16 16 0 0 1 416 240m0-80H224.5c-8.64 0-16.1-6.64-16.48-15.28A16 16 0 0 1 224 128h191.5c8.64 0 16.1 6.64 16.48 15.28A16 16 0 0 1 416 160"/><path fill="currentColor" d="M336 424v-88a16 16 0 0 0-16-16H48a32.1 32.1 0 0 0-32 32.05c0 50.55 5.78 71.57 14.46 87.57C45.19 466.79 71.86 480 112 480h245.68a4 4 0 0 0 2.85-6.81C351.07 463.7 336 451 336 424"/></svg>
                        <span>Quotation</span>
                    </a>
                </li>
                <li
                    class="sidebar-item has-sub {{Route::is('purchase*') ? 'active' : ''}}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-credit-card-2-back-fill"></i>
                        <span>Purchase Order</span>
                    </a>
                    
                    <ul class="submenu ">
                        <li class="submenu-item  ">
                            <a href="{{route('purchase.index')}}" class="submenu-link">All Purchase</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('purchase.process')}}" class="submenu-link">All Processed Purchase</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('purchase.index.deleted')}}" class="submenu-link">Deleted Purchase Order</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item {{Route::is('invoice*') ? 'active' : ''}}">
                    <a href="{{route('invoice.index')}}" class='sidebar-link'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M7.245 2h9.51c1.159 0 1.738 0 2.206.163a3.05 3.05 0 0 1 1.881 1.936C21 4.581 21 5.177 21 6.37v14.004c0 .858-.985 1.314-1.608.744a.946.946 0 0 0-1.284 0l-.483.442a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0a1.657 1.657 0 0 0-2.25 0a1.657 1.657 0 0 1-2.25 0l-.483-.442a.946.946 0 0 0-1.284 0c-.623.57-1.608.114-1.608-.744V6.37c0-1.193 0-1.79.158-2.27c.3-.913.995-1.629 1.881-1.937C5.507 2 6.086 2 7.245 2M7 6.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 10.25a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5zM7 13.75a.75.75 0 0 0 0 1.5h.5a.75.75 0 0 0 0-1.5zm3.5 0a.75.75 0 0 0 0 1.5H17a.75.75 0 0 0 0-1.5z" clip-rule="evenodd"/></svg>
                        <span>Invoice</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{Route::is('debt*') ? 'active' : ''}}">
                    <a href="{{route('debt.index')}}" class='sidebar-link'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M18 2a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3zM8 17a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 9 18.01l-.007-.127A1 1 0 0 0 8 17m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 13 18.01l-.007-.127A1 1 0 0 0 12 17m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 17 18.01l-.007-.127A1 1 0 0 0 16 17m-8-4a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 9 14.01l-.007-.127A1 1 0 0 0 8 13m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 13 14.01l-.007-.127A1 1 0 0 0 12 13m4 0a1 1 0 0 0-1 1l.007.127A1 1 0 0 0 17 14.01l-.007-.127A1 1 0 0 0 16 13m-1-7H9a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2" />
                        </svg>
                        <span>Debt</span>
                    </a>
                </li>
                <li class="sidebar-title text-secondary">Accounting</li>
                <li
                    class="sidebar-item has-sub {{Route::is('account*') || Route::is('account_type*') ? 'active' : ''}}">
                    <a href="#" class='sidebar-link'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24">
                            <g fill="none">
                                <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                <path fill="currentColor" d="M7 13a2 2 0 0 1 1.995 1.85L9 15v3a2 2 0 0 1-1.85 1.995L7 20H4a2 2 0 0 1-1.995-1.85L2 18v-3a2 2 0 0 1 1.85-1.995L4 13zm9 4a1 1 0 0 1 .117 1.993L16 19h-4a1 1 0 0 1-.117-1.993L12 17zm4-4a1 1 0 1 1 0 2h-8a1 1 0 1 1 0-2zM7 3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm9 4a1 1 0 0 1 .117 1.993L16 9h-4a1 1 0 0 1-.117-1.993L12 7zm4-4a1 1 0 0 1 .117 1.993L20 5h-8a1 1 0 0 1-.117-1.993L12 3z" />
                            </g>
                        </svg>
                        <span>Chart of Accounts</span>
                    </a>
                    
                    <ul class="submenu ">
                        <li class="submenu-item  ">
                            <a href="{{route('account.index')}}" class="submenu-link">All Accounts</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('account_type.index')}}" class="submenu-link">All Account Type</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="sidebar-item has-sub {{Route::is('journal*') ? 'active' : ''}}">
                    <a href="#" class='sidebar-link'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 20 20">
                            <path fill="currentColor" d="M2 18.5A1.5 1.5 0 0 0 3.5 20H5V0H3.5A1.5 1.5 0 0 0 2 1.5zM6 0v20h10a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm7 8H8V7h5zm3-2H8V5h8z" />
                        </svg>
                        <span>Journal</span>
                    </a>
                    
                    <ul class="submenu ">
                        <li class="submenu-item  ">
                            <a href="{{route('jurnal.index')}}" class="submenu-link">All Journal</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('jurnal.add')}}" class="submenu-link">Input New Jurnal</a>
                        </li>
                    </ul>
                </li>

                <li
                    class="sidebar-item has-sub {{Route::is('journal*') ? 'active' : ''}}">
                    <a href="#" class='sidebar-link'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M6 23H2a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1" opacity="0.25" />
                            <path fill="currentColor" d="M14 23h-4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v20a1 1 0 0 1-1 1" />
                            <path fill="currentColor" d="M22 23h-4a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1" opacity="0.5" />
                        </svg>
                        <span>Reports</span>
                    </a>
                    
                    <ul class="submenu ">
                        <li class="submenu-item  ">
                            <a href="{{route('report.balance')}}" class="submenu-link">Balance Sheet</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('report.cashFlow')}}" class="submenu-link">Cash Flow</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('report.incomeStatement')}}" class="submenu-link">Income Statement</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('report.generalLedger')}}" class="submenu-link">General Ledger</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('report.changesInEquity')}}" class="submenu-link">Changes In Equity</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="{{route('report.accountsReceivableAndPayable')}}" class="submenu-link">Receivable And Payable</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>