@extends('admin.layout.index')

@section('title', 'Work Create')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <p class="card-title-desc">Adding work for {{ Carbon\Carbon::parse($date)->format('d M Y') }}</p>
                    <style>
                        .input-item {
                            margin-top: 1rem;
                        }

                        td,
                        th {
                            border: 1px solid black;
                            padding: 0.5rem;
                            text-align: center;
                        }
                    </style>
                    <form action="{{ route('work.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">
                        <div class="row">
                            <table border="1" id="work_table">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>User Name</th>
                                        <th>Account Name</th>
                                        <th>Offer Name</th>
                                        <th>Device Name</th>
                                        <th>Offers</th>
                                        <th>Offer Add</th>
                                        <th>Account Add</th>
                                        <th>User Add</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="main_row first_row">
                                        <td class="sl_no">1</td>
                                        <td class="user_name">
                                            <select name="user_name" class="form-control">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="account_name">
                                            <select name="account_name" class="form-control">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="offer_name">
                                            <select name="offer_name" class="form-control">
                                                @foreach ($offers as $offer)
                                                    <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="mobile_name">Samsung</td>
                                        <td class="offer">1</td>
                                        <td class="offer_add"><span class="btn btn-primary btn-sm add_offer"
                                                onclick="addOffer(this)" data-offer="1">Add
                                                Offer</span></td>
                                        <td class="account_add"><span class="btn btn-secondary btn-sm"
                                                onclick="addAccount(this)">Add
                                                Account</span></td>
                                        <td class="user_add"><span class="btn btn-info btn-sm" onclick="addUser(this)">Add
                                                User</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="input-item">
                            <input type="submit" value="Add Work" class="btn btn-primary">
                        </div>
                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <script>
        let serialNo = 1;
        // Add Offer 
        function addOffer(element) {

            let tr = element.parentElement.parentElement;
            let offerTr = `
                <tr class="offerTr">
                    <td class="offer_name">
                        <select name="offer_name" class="form-control">
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="mobile_name">Samsung <span class="btn btn-danger btn-sm" onclick="deleteOffer(this)">Delete Offer</span></td>
                </tr>
            `;

            var offerValue = element.dataset.offer;
            var newOfferValue = parseInt(offerValue) + 1;
            element.dataset.offer = newOfferValue;

            tr.querySelector('.offer').innerHTML = newOfferValue;
            tr.insertAdjacentHTML('afterend', offerTr);

            if (tr.classList.contains('accountTr')) {
                increaseRawspanAccName(tr);
                increaseRawspanOffer(tr);
                increaseRawspanOfferAdd(tr);

                let mainRow = findPrevMainRow(tr);
                increaseRawspanSlNo(mainRow);
                increaseRawspanUsername(mainRow);
                increaseRawspanAccAdd(mainRow);
                increaseRawspanUserAdd(mainRow);

            } else {
                increaseRawspanSlNo(tr);
                increaseRawspanUsername(tr);
                increaseRawspanAccName(tr);
                increaseRawspanOffer(tr);
                increaseRawspanOfferAdd(tr);
                increaseRawspanAccAdd(tr);
                increaseRawspanUserAdd(tr);
            }
        }

        // Add Account
        function addAccount(element) {
            let accountTr = `
                <tr class="accountTr">
                    <td class="account_name">
                        <select name="account_name" class="form-control">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="offer_name">
                        <select name="offer_name" class="form-control">
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select>     
                    </td>
                    <td class="mobile_name">Samsung</td>
                    <td class="offer">1</td>
                    <td class="offer_add"><span class="btn btn-primary btn-sm add_offer" onclick="addOffer(this)" data-offer="1">Add Offer</span><span class="btn btn-danger btn-sm" onclick="deleteAccount(this)">Delete Account</span></td>
                </tr>
            `;
            let tr = element.parentElement.parentElement;

            let insertAfterTr = findNextNonOfferOrNonAccTr(tr);

            if (insertAfterTr) {
                if (insertAfterTr.classList.contains('main_row')) {
                    insertAfterTr.insertAdjacentHTML('beforebegin', accountTr);
                } else {
                    insertAfterTr.insertAdjacentHTML('afterend', accountTr);
                }
            } else {
                tr.parentElement.insertAdjacentHTML('beforeend', accountTr);
            }

            increaseRawspanSlNo(tr);
            increaseRawspanUsername(tr);
            increaseRawspanAccAdd(tr);
            increaseRawspanUserAdd(tr);
        }

        // Add User
        function addUser(element) {
            serialNo++;
            let userTr = `
                <tr class="main_row">
                    <td class="sl_no">${serialNo}</td>
                    <td class="user_name">
                        <select name="user_name" class="form-control">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="account_name">
                        <select name="account_name" class="form-control">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="offer_name">
                        <select name="offer_name" class="form-control">
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td class="mobile_name">Samsung</td>
                    <td class="offer">1</td>
                    <td class="offer_add"><span class="btn btn-primary btn-sm add_offer" onclick="addOffer(this)" data-offer="1">Add Offer</span></td>
                    <td class="account_add"><span class="btn btn-secondary btn-sm" onclick="addAccount(this)">Add Account</span><span class="btn btn-danger btn-sm" onclick="deleteUser(this)"> Delete User</span></td>
                </tr>
            `;

            let workTableBody = document.querySelector('#work_table tbody');
            workTableBody.insertAdjacentHTML('beforeend', userTr);
            element.parentElement.rowSpan = element.parentElement.rowSpan + 1;
        }

        // Deleting Offer
        function deleteOffer(element) {
            if (confirm('Do you sure want to delete this?')) {

                let mainTr = findPrevMainRow(element.parentElement.parentElement);
                let accTr = findPrevAccRow(element.parentElement.parentElement);

                if (accTr) {
                    decreaseRawspanAccName(accTr);
                    decreaseRawspanOffer(accTr);
                    decreaseRawspanOfferAdd(accTr);

                    var offerValue = accTr.querySelector('.add_offer').dataset.offer;
                    var newOfferValue = parseInt(offerValue) - 1;

                    accTr.querySelector('.add_offer').dataset.offer = newOfferValue;
                    accTr.querySelector('.offer').innerHTML = newOfferValue;
                } else {
                    decreaseRawspanAccName(mainTr);
                    decreaseRawspanOffer(mainTr);
                    decreaseRawspanOfferAdd(mainTr);

                    var offerValue = mainTr.querySelector('.add_offer').dataset.offer;
                    var newOfferValue = parseInt(offerValue) - 1;

                    mainTr.querySelector('.add_offer').dataset.offer = newOfferValue;
                    mainTr.querySelector('.offer').innerHTML = newOfferValue;
                }

                decreaseRawspanSlNo(mainTr);
                decreaseRawspanUsername(mainTr);
                decreaseRawspanAccAdd(mainTr);
                decreaseRawspanUserAdd(mainTr);

                element.parentElement.parentElement.remove();

            }
        }

        // Deleting Account
        function deleteAccount(element) {
            if (confirm('Delete this Account?')) {
                let mainTr = findPrevMainRow(element.parentElement.parentElement);
                decreaseRawspanSlNo(mainTr);
                decreaseRawspanUsername(mainTr);
                decreaseRawspanAccAdd(mainTr);
                decreaseRawspanUserAdd(mainTr);

                let offerTrs = getNextOfferTrs(element.parentElement.parentElement);

                offerTrs.forEach(trs => {
                    trs.remove();
                    decreaseRawspanSlNo(mainTr);
                    decreaseRawspanUsername(mainTr);
                    decreaseRawspanAccAdd(mainTr);
                    decreaseRawspanUserAdd(mainTr);
                });
                element.parentElement.parentElement.remove();
            }
        }

        // Deleting User
        function deleteUser(element) {
            if (confirm('Delete user?')) {

                let offerTrsAndAccTrs = getNextOfferTrsOrAccTrs(element.parentElement.parentElement);
                offerTrsAndAccTrs.forEach(trs => {
                    trs.remove();
                    document.querySelector('.user_add').rowSpan--;
                });

                document.querySelector('.user_add').rowSpan--;
                element.parentElement.parentElement.remove();
            }
        }

        // Finding Some tr
        function findNextNonOfferOrNonAccTr(currentTr) {
            let nextTr = currentTr.nextElementSibling;

            while (nextTr && (nextTr.classList.contains('offerTr') || nextTr.classList.contains('accountTr'))) {
                nextTr = nextTr.nextElementSibling;
            }
            return nextTr;
        }

        // Getting Next offer table rows
        function getNextOfferTrs(currentTr) {
            let nextTr = currentTr.nextElementSibling;

            trs = [];
            while (nextTr && nextTr.classList.contains('offerTr')) {
                trs.push(nextTr);
                nextTr = nextTr.nextElementSibling;
            }

            return trs;
        }

        // Getting Next table rows that contains offerTr or accountTr.
        function getNextOfferTrsOrAccTrs(currentTr) {
            let nextTr = currentTr.nextElementSibling;

            trs = [];
            while (nextTr && (nextTr.classList.contains('offerTr') || nextTr.classList.contains('accountTr'))) {
                trs.push(nextTr);
                nextTr = nextTr.nextElementSibling;
            }

            return trs;
        }

        // Finding previous Main row
        function findPrevMainRow(currentTr) {
            let previousTr = currentTr.previousElementSibling;

            while (previousTr && !previousTr.classList.contains('main_row')) {
                previousTr = previousTr.previousElementSibling;
            }
            return previousTr;
        }

        // Finding previous Account row
        function findPrevAccRow(currentTr) {
            let previousTr = currentTr.previousElementSibling;

            while (previousTr && !previousTr.classList.contains('accountTr')) {
                if (previousTr.classList.contains('main_row')) {
                    return false;
                }
                previousTr = previousTr.previousElementSibling;
            }
            return previousTr;
        }

        // Functions for increasing rowspan for serial no
        function increaseRawspanSlNo(element) {
            let sl_no = element.querySelector('.sl_no');
            sl_no.rowSpan++;
        }

        // Functions for increasing rowspan for user name
        function increaseRawspanUsername(element) {
            let user_name = element.querySelector('.user_name');
            user_name.rowSpan++;
        }

        // Functions for increasing rowspan for Account Name
        function increaseRawspanAccName(element) {
            let account_name = element.querySelector('.account_name');
            account_name.rowSpan++;
        }

        // Functions for increasing rowspan for Offer
        function increaseRawspanOffer(element) {
            let offer = element.querySelector('.offer');
            offer.rowSpan++;
        }

        // Functions for increasing rowspan for Add Offer
        function increaseRawspanOfferAdd(element) {
            let offer_add = element.querySelector('.offer_add');
            offer_add.rowSpan++;
        }

        // Functions for increasing rowspan for Add Account
        function increaseRawspanAccAdd(element) {
            let account_add = element.querySelector('.account_add');
            account_add.rowSpan++;
        }

        // Functions for increasing rowspan for Add User
        function increaseRawspanUserAdd(element) {
            let user_add = document.querySelector('.user_add');
            user_add.rowSpan++;
        }

        // Functions for Decreasing rowspan for serial No
        function decreaseRawspanSlNo(element) {
            let sl_no = element.querySelector('.sl_no');
            sl_no.rowSpan--;
        }

        // Functions for Decreasing rowspan for User Name
        function decreaseRawspanUsername(element) {
            let user_name = element.querySelector('.user_name');
            user_name.rowSpan--;
        }

        // Functions for Decreasing rowspan for Account Name
        function decreaseRawspanAccName(element) {
            let account_name = element.querySelector('.account_name');
            account_name.rowSpan--;
        }

        // Functions for Decreasing rowspan for Offer
        function decreaseRawspanOffer(element) {
            let offer = element.querySelector('.offer');
            offer.rowSpan--;
        }

        // Functions for Decreasing rowspan for Add Offer
        function decreaseRawspanOfferAdd(element) {
            let offer_add = element.querySelector('.offer_add');
            offer_add.rowSpan--;
        }

        // Functions for Decreasing rowspan for Add Account
        function decreaseRawspanAccAdd(element) {
            let account_add = element.querySelector('.account_add');
            account_add.rowSpan--;
        }

        // Functions for Decreasing rowspan for Add User
        function decreaseRawspanUserAdd(element) {
            let user_add = document.querySelector('.user_add');
            user_add.rowSpan--;
        }
    </script>
@endsection
