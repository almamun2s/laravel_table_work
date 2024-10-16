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
                    @php
                        $deviceArr = [
                            'device_id' => $devices->first()->id,
                            'offer_id' => $offers->first()->id,
                            'account_id' => $accounts->first()->id,
                            'lead' => 1,
                            'user_id' => $users->first()->id,
                        ];
                        $deviceArr = json_encode($deviceArr);
                    @endphp
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
                                        <th>Device Add</th>
                                        <th>Offers</th>
                                        <th>Lead</th>
                                        <th>Offer Add</th>
                                        <th>Account Add</th>
                                        <th>User Add</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="main_row first_row">
                                        <td class="sl_no">1</td>
                                        <td class="user_name">
                                            <select name="user_name" class="form-control" onchange="updateUser(this)">
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="account_name">
                                            <select name="account_name" class="form-control" onchange="updateAccount(this)">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="offer_name">
                                            <select name="offer_name" class="form-control" onchange="updateOffer(this)">
                                                @foreach ($offers as $offer)
                                                    <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="device_name">
                                            <select name="device_name" class="form-control" onchange="updateDevice(this)">
                                                @foreach ($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="works[]" class="works"
                                                value="{{ $deviceArr }}">
                                        </td>
                                        <td class="device_add"><span class="btn btn-sm add_device"
                                                style="background-color: pink;" onclick="addDevice(this)">Add
                                                Device</span></td>
                                        <td class="offer" data-offer="1">1</td>
                                        <td class="lead">
                                            <input class="form-control" type="number" min="0" value="1"
                                                onchange="updateAccount(this)">
                                        </td>
                                        <td class="offer_add"><span class="btn btn-primary btn-sm add_offer"
                                                onclick="addOffer(this)">Add
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

        function addDevice(element) {
            let tr = element.parentElement.parentElement;
            let deviceTr = `
                <tr class="deviceTr">
                    <td class="device_name">
                        <select name="device_name" class="form-control" onchange="updateDevice(this)">
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="works[]" class="works" value="{{ $deviceArr }}">
                        <span class="btn btn-danger btn-sm" onclick="deleteDevice(this)">Delete Device</span>
                    </td>
                </tr>
            `;

            tr.insertAdjacentHTML('afterend', deviceTr);

            if (tr.classList.contains('offerTr')) {
                let mainRow = findPrevMainRow(tr);
                let accRow = findPrevAccRow(tr);

                if (accRow) {
                    increaseRawspanAccName(accRow);
                    increaseRawspanOffer(accRow);
                    increaseRawspanLead(accRow);
                    increaseRawspanOfferAdd(accRow);

                    var offerElement = accRow.querySelector('.offer');
                } else {
                    increaseRawspanAccName(mainRow);
                    increaseRawspanOffer(mainRow);
                    increaseRawspanLead(mainRow);
                    increaseRawspanOfferAdd(mainRow);

                    var offerElement = mainRow.querySelector('.offer');
                }

                increaseRawspanSlNo(mainRow);
                increaseRawspanUsername(mainRow);
                increaseRawspanAccAdd(mainRow);
                increaseRawspanUserAdd(mainRow);

            } else if (tr.classList.contains('accountTr')) {
                let mainRow = findPrevMainRow(tr);
                increaseRawspanSlNo(mainRow);
                increaseRawspanUsername(mainRow);
                increaseRawspanAccName(tr);
                increaseRawspanOffer(tr);
                increaseRawspanLead(tr);
                increaseRawspanOfferAdd(tr);
                increaseRawspanAccAdd(mainRow);
                increaseRawspanUserAdd(mainRow);

                var offerElement = tr.querySelector('.offer');
            } else {
                increaseRawspanSlNo(tr);
                increaseRawspanUsername(tr);
                increaseRawspanAccName(tr);
                increaseRawspanOffer(tr);
                increaseRawspanLead(tr);
                increaseRawspanOfferAdd(tr);
                increaseRawspanAccAdd(tr);
                increaseRawspanUserAdd(tr);

                var offerElement = tr.querySelector('.offer');
            }
            increaseRawspanOfferName(tr);
            increaseRawspanDeviceAdd(tr);

            var offerValue = offerElement.dataset.offer;
            var newOfferValue = parseInt(offerValue) + 1;
            offerElement.dataset.offer = newOfferValue;
            offerElement.innerHTML = newOfferValue;

        }

        // Add Offer 
        function addOffer(element) {

            let tr = element.parentElement.parentElement;
            let offerTr = `
                <tr class="offerTr">
                    <td class="offer_name">
                        <select name="offer_name" class="form-control" onchange="updateOffer(this)">
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="device_name">
                        <select name="device_name" class="form-control" onchange="updateDevice(this)">
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="works[]" class="works" value="{{ $deviceArr }}">
                    </td>
                    <td class="device_add"><span class="btn btn-sm add_device" style="background-color: pink;" onclick="addDevice(this)">Add Device</span><span class="btn btn-danger btn-sm" onclick="deleteOffer(this)">Delete Offer</span></td>
                </tr>
            `;

            let insertAfterTr = findNextNonDeviceTr(tr);

            if (insertAfterTr) {
                if (insertAfterTr.classList.contains('main_row')) {
                    insertAfterTr.insertAdjacentHTML('beforebegin', offerTr);
                } else if (insertAfterTr.classList.contains('accountTr')) {
                    insertAfterTr.insertAdjacentHTML('beforebegin', offerTr)
                } else {
                    insertAfterTr.insertAdjacentHTML('afterend', offerTr);
                }
            } else {
                tr.parentElement.insertAdjacentHTML('beforeend', offerTr);
            }

            if (tr.classList.contains('accountTr')) {
                increaseRawspanAccName(tr);
                increaseRawspanOffer(tr);
                increaseRawspanLead(tr);
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
                increaseRawspanLead(tr);
                increaseRawspanOfferAdd(tr);
                increaseRawspanAccAdd(tr);
                increaseRawspanUserAdd(tr);
            }

            var offerElement = tr.querySelector('.offer');
            var offerValue = offerElement.dataset.offer;
            var newOfferValue = parseInt(offerValue) + 1;
            offerElement.dataset.offer = newOfferValue;
            offerElement.innerHTML = newOfferValue;
        }

        // Add Account
        function addAccount(element) {
            let accountTr = `
                <tr class="accountTr">
                    <td class="account_name">
                        <select name="account_name" class="form-control" onchange="updateAccount(this)">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="offer_name">
                        <select name="offer_name" class="form-control" onchange="updateOffer(this)">
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select>     
                    </td>
                    <td class="device_name">
                        <select name="device_name" class="form-control" onchange="updateDevice(this)">
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="works[]" class="works" value="{{ $deviceArr }}">
                    </td>
                    <td class="device_add"><span class="btn btn-sm add_device" style="background-color: pink;" onclick="addDevice(this)">Add Device</span></td>
                    <td class="offer" data-offer="1">1</td>
                    <td class="lead">
                        <input class="form-control" type="number" min="0" value="1" onchange="updateAccount(this)">
                    </td>
                    <td class="offer_add"><span class="btn btn-primary btn-sm add_offer" onclick="addOffer(this)">Add Offer</span><span class="btn btn-danger btn-sm" onclick="deleteAccount(this)">Delete Account</span></td>
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
                        <select name="user_name" class="form-control" onchange="updateUser(this)">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="account_name">
                        <select name="account_name" class="form-control" onchange="updateAccount(this)">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>    
                    </td>
                    <td class="offer_name">
                        <select name="offer_name" class="form-control" onchange="updateOffer(this)">
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td class="device_name">
                        <select name="device_name" class="form-control" onchange="updateDevice(this)">
                            @foreach ($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="works[]" class="works" value="{{ $deviceArr }}">
                    </td>
                    <td class="device_add"><span class="btn btn-sm add_device" style="background-color: pink;" onclick="addDevice(this)">Add Device</span></td>
                    <td class="offer" data-offer="1">1</td>
                    <td class="lead">
                        <input class="form-control" type="number" min="0" value="1" onchange="updateAccount(this)">
                    </td>
                    <td class="offer_add"><span class="btn btn-primary btn-sm add_offer" onclick="addOffer(this)">Add Offer</span></td>
                    <td class="account_add"><span class="btn btn-secondary btn-sm" onclick="addAccount(this)">Add Account</span><span class="btn btn-danger btn-sm" onclick="deleteUser(this)"> Delete User</span></td>
                </tr>
            `;

            let workTableBody = document.querySelector('#work_table tbody');
            workTableBody.insertAdjacentHTML('beforeend', userTr);
            element.parentElement.rowSpan = element.parentElement.rowSpan + 1;
        }

        // =================================== Deleting Device ===================================
        function deleteDevice(element) {
            if (confirm('Do you want to delete this?')) {
                let mainTr = findPrevMainRow(element.parentElement.parentElement);
                let accTr = findPrevAccRow(element.parentElement.parentElement);
                let offerTr = findPrevOfferRow(element.parentElement.parentElement);

                if (offerTr && accTr) {
                    decreaseRawspanAccName(accTr);
                    decreaseRawspanOfferName(offerTr);
                    decreaseRawspanDeviceAdd(offerTr);
                    decreaseRawspanOffer(accTr);
                    decreaseRawspanLead(accTr);
                    decreaseRawspanOfferAdd(accTr);
                } else if (offerTr) {
                    decreaseRawspanAccName(mainTr);
                    decreaseRawspanOfferName(offerTr);
                    decreaseRawspanDeviceAdd(offerTr);
                    decreaseRawspanOffer(mainTr);
                    decreaseRawspanLead(mainTr);
                    decreaseRawspanOfferAdd(mainTr);

                    var offerElement = mainTr.querySelector('.offer');
                } else if (accTr) {
                    decreaseRawspanAccName(accTr);
                    decreaseRawspanOfferName(accTr);
                    decreaseRawspanDeviceAdd(accTr);
                    decreaseRawspanOffer(accTr);
                    decreaseRawspanLead(accTr);
                    decreaseRawspanOfferAdd(accTr);

                    var offerElement = accTr.querySelector('.offer');

                } else {
                    decreaseRawspanAccName(mainTr);
                    decreaseRawspanOfferName(mainTr);
                    decreaseRawspanDeviceAdd(mainTr);
                    decreaseRawspanOffer(mainTr);
                    decreaseRawspanLead(mainTr);
                    decreaseRawspanOfferAdd(mainTr);

                    var offerElement = mainTr.querySelector('.offer');
                }

                decreaseRawspanSlNo(mainTr);
                decreaseRawspanUsername(mainTr);
                decreaseRawspanAccAdd(mainTr);
                decreaseRawspanUserAdd(mainTr);
                element.parentElement.parentElement.remove();

                var offerValue = offerElement.dataset.offer;
                var newOfferValue = parseInt(offerValue) - 1;
                offerElement.dataset.offer = newOfferValue;
                offerElement.innerHTML = newOfferValue;
            }
        }

        // =================================== Deleting Offer ===================================
        function deleteOffer(element) {
            if (confirm('Do you sure want to delete this?')) {

                let mainTr = findPrevMainRow(element.parentElement.parentElement);
                let accTr = findPrevAccRow(element.parentElement.parentElement);
                let offerElementMain;

                if (accTr) {
                    decreaseRawspanAccName(accTr);
                    decreaseRawspanOffer(accTr);
                    decreaseRawspanLead(accTr);
                    decreaseRawspanOfferAdd(accTr);

                    offerElementMain = accTr.querySelector('.offer');
                } else {
                    decreaseRawspanAccName(mainTr);
                    decreaseRawspanOffer(mainTr);
                    decreaseRawspanLead(mainTr);
                    decreaseRawspanOfferAdd(mainTr);

                    offerElementMain = mainTr.querySelector('.offer');
                }
                if (offerElementMain) {
                    var offerValue = parseInt(offerElementMain.dataset.offer) || 0;
                    var newOfferValue = offerValue - 1;
                    offerElementMain.dataset.offer = newOfferValue;
                    offerElementMain.innerHTML = newOfferValue;
                }

                decreaseRawspanSlNo(mainTr);
                decreaseRawspanUsername(mainTr);
                decreaseRawspanAccAdd(mainTr);
                decreaseRawspanUserAdd(mainTr);

                let deviceTrs = getNextDeviceTrs(element.parentElement.parentElement);

                deviceTrs.forEach(trs => {
                    let offerElement;

                    if (accTr) {
                        decreaseRawspanAccName(accTr);
                        decreaseRawspanOffer(accTr);
                        decreaseRawspanLead(accTr);
                        decreaseRawspanOfferAdd(accTr);

                        offerElement = accTr.querySelector('.offer');
                    } else {
                        decreaseRawspanAccName(mainTr);
                        decreaseRawspanOffer(mainTr);
                        decreaseRawspanLead(mainTr);
                        decreaseRawspanOfferAdd(mainTr);

                        offerElement = mainTr.querySelector('.offer');
                    }

                    decreaseRawspanSlNo(mainTr);
                    decreaseRawspanUsername(mainTr);
                    decreaseRawspanAccAdd(mainTr);
                    decreaseRawspanUserAdd(mainTr);

                    trs.remove();

                    if (offerElement) {
                        var offerValue = parseInt(offerElement.dataset.offer) || 0;
                        var newOfferValue = offerValue - 1;
                        offerElement.dataset.offer = newOfferValue;
                        offerElement.innerHTML = newOfferValue;
                    }
                });

                element.parentElement.parentElement.remove();

            }
        }

        // =================================== Deleting Account ===================================
        function deleteAccount(element) {
            if (confirm('Delete this Account?')) {
                let mainTr = findPrevMainRow(element.parentElement.parentElement);
                decreaseRawspanSlNo(mainTr);
                decreaseRawspanUsername(mainTr);
                decreaseRawspanAccAdd(mainTr);
                decreaseRawspanUserAdd(mainTr);

                let offerTrs = getNextOfferTrsOrDeviceTrs(element.parentElement.parentElement);

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

        // =================================== Deleting User ===================================
        function deleteUser(element) {
            if (confirm('Delete user?')) {

                let offerTrsAndAccTrs = getNextAccTrsOfferTrsOrDeviceTrs(element.parentElement.parentElement);
                offerTrsAndAccTrs.forEach(trs => {
                    trs.remove();
                    document.querySelector('.user_add').rowSpan--;
                });

                document.querySelector('.user_add').rowSpan--;
                element.parentElement.parentElement.remove();
            }
        }

        // Find next non device tr
        function findNextNonDeviceTr(currentTr) {
            let nextTr = currentTr.nextElementSibling;

            while (nextTr && (nextTr.classList.contains('deviceTr') || nextTr.classList.contains('offerTr'))) {

                nextTr = nextTr.nextElementSibling;
            }

            return nextTr;
        }

        // Finding Some tr
        function findNextNonOfferOrNonAccTr(currentTr) {
            let nextTr = currentTr.nextElementSibling;

            while (nextTr && (nextTr.classList.contains('offerTr') || nextTr.classList.contains('accountTr') || nextTr
                    .classList.contains('deviceTr'))) {
                nextTr = nextTr.nextElementSibling;
            }
            return nextTr;
        }

        // Getting Next Device table rows
        function getNextDeviceTrs(currentTr) {
            let nextTr = currentTr.nextElementSibling;
            trs = [];
            while (nextTr && nextTr.classList.contains('deviceTr')) {
                trs.push(nextTr);
                nextTr = nextTr.nextElementSibling;
            }
            return trs;
        }

        // Getting Next offer table rows
        function getNextOfferTrsOrDeviceTrs(currentTr) {
            let nextTr = currentTr.nextElementSibling;

            trs = [];
            while (nextTr && (nextTr.classList.contains('offerTr') || nextTr.classList.contains('deviceTr'))) {
                trs.push(nextTr);
                nextTr = nextTr.nextElementSibling;
            }

            return trs;
        }

        // Getting Next table rows that contains offerTr or accountTr.
        function getNextAccTrsOfferTrsOrDeviceTrs(currentTr) {
            let nextTr = currentTr.nextElementSibling;

            trs = [];
            while (nextTr && (nextTr.classList.contains('offerTr') || nextTr.classList.contains('accountTr') || nextTr
                    .classList.contains('deviceTr'))) {
                trs.push(nextTr);
                nextTr = nextTr.nextElementSibling;
            }

            return trs;
        }

        function findPrevOfferRow(currentTr) {
            let previousTr = currentTr.previousElementSibling;

            while (previousTr && !previousTr.classList.contains('offerTr')) {
                if (previousTr.classList.contains('main_row') || previousTr.classList.contains('accountTr')) {
                    return false;
                }
                previousTr = previousTr.previousElementSibling;
            }
            return previousTr;
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

        // Getting all next device Rows with the current Row
        function getAllNextDeviceTrs(currentTr) {
            let rows = [];
            rows.push(currentTr);
            let nextRow = currentTr.nextElementSibling;

            while (nextRow && nextRow.classList.contains('deviceTr')) {
                rows.push(nextRow);
                nextRow = nextRow.nextElementSibling;
            }
            return rows;
        }

        // Getting all next offer rows and device rows with the current Row
        function getAllNextOfferTrAndDeviceTr(currentTr) {
            let rows = [];
            rows.push(currentTr);
            let nextRow = currentTr.nextElementSibling;

            while (nextRow && (nextRow.classList.contains('offerTr') || nextRow.classList.contains('deviceTr'))) {
                rows.push(nextRow);
                nextRow = nextRow.nextElementSibling;
            }

            return rows;
        }

        // Getting all next account, offer and device rows with the current Row
        function getAllNextAccountOfferAndDeviceTr(currentTr) {
            let rows = [];
            rows.push(currentTr);
            let nextRow = currentTr.nextElementSibling;

            while (nextRow && (nextRow.classList.contains('accountTr') || nextRow.classList.contains('offerTr') || nextRow
                    .classList.contains('deviceTr'))) {
                rows.push(nextRow);
                nextRow = nextRow.nextElementSibling;
            }

            return rows;
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

        // Functions for increasing rowspan for Offer Name
        function increaseRawspanOfferName(element) {
            let offer_name = element.querySelector('.offer_name');
            offer_name.rowSpan++;
        }

        // Functions for increasing rowspan for Offer Name
        function increaseRawspanDeviceAdd(element) {
            let device_add = element.querySelector('.device_add');
            device_add.rowSpan++;
        }

        // Functions for increasing rowspan for Offer
        function increaseRawspanOffer(element) {
            let offer = element.querySelector('.offer');
            offer.rowSpan++;
        }

        // Functions for increasing rowspan for Lead
        function increaseRawspanLead(element) {
            let lead = element.querySelector('.lead');
            lead.rowSpan++;
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

        // Functions for Decreasing rowspan for Offer Name
        function decreaseRawspanOfferName(element) {
            let offer_name = element.querySelector('.offer_name');
            offer_name.rowSpan--;
        }

        // Functions for Decreasing rowspan for device add
        function decreaseRawspanDeviceAdd(element) {
            let device_add = element.querySelector('.device_add');
            device_add.rowSpan--;
        }

        // Functions for Decreasing rowspan for Offer
        function decreaseRawspanOffer(element) {
            let offer = element.querySelector('.offer');
            offer.rowSpan--;
        }

        // Functions for increasing rowspan for Lead
        function decreaseRawspanLead(element) {
            let lead = element.querySelector('.lead');
            lead.rowSpan--;
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

        // =============================== Updating data =============================== 
        function updateDevice(element) {
            let deviceId = element.value;

            var hiddenInput = element.parentElement.querySelector('.works');
            if (hiddenInput.value && isJSONParseable(hiddenInput.value)) {
                let prevData = JSON.parse(hiddenInput.value);

                prevData.device_id = deviceId;

                prevData = JSON.stringify(prevData);
                hiddenInput.value = prevData;
            } else {
                var hiddenInputValues = {
                    'device_id': deviceId
                };

                hiddenInput.value = JSON.stringify(hiddenInputValues);
            }
        }

        function updateOffer(element) {
            let offerId = element.value;

            var hiddenInputRows = getAllNextDeviceTrs(element.parentElement.parentElement);
            hiddenInputRows.forEach(hiddenInputRow => {
                let hiddenInput = hiddenInputRow.querySelector('.works');

                if (hiddenInput.value && isJSONParseable(hiddenInput.value)) {
                    let prevData = JSON.parse(hiddenInput.value);

                    prevData.offer_id = offerId;

                    prevData = JSON.stringify(prevData);
                    hiddenInput.value = prevData;
                } else {
                    var hiddenInputValues = {
                        'offer_id': offerId
                    }
                    hiddenInput.value = JSON.stringify(hiddenInputValues);
                }
            });
        }

        function updateAccount(element) {
            let tr = element.parentElement.parentElement;
            let accountId = tr.querySelector('.account_name select').value;
            let lead = tr.querySelector('.lead input').value;

            let hiddenInputRows = getAllNextOfferTrAndDeviceTr(element.parentElement.parentElement);
            hiddenInputRows.forEach(hiddenInputRow => {
                let hiddenInput = hiddenInputRow.querySelector('.works');

                if (hiddenInput.value && isJSONParseable(hiddenInput.value)) {
                    let prevData = JSON.parse(hiddenInput.value);

                    prevData.account_id = accountId;
                    prevData.lead = lead;

                    prevData = JSON.stringify(prevData);
                    hiddenInput.value = prevData;
                } else {
                    var hiddenInputValues = {
                        'account_id': accountId,
                        'lead': lead,
                    }
                    hiddenInput.value = JSON.stringify(hiddenInputValues);
                }
            });
        }

        function updateUser(element) {
            let userId = element.value;

            let hiddenInputRows = getAllNextAccountOfferAndDeviceTr(element.parentElement.parentElement);
            hiddenInputRows.forEach(hiddenInputRow => {
                let hiddenInput = hiddenInputRow.querySelector('.works');

                if (hiddenInput.value && isJSONParseable(hiddenInput.value)) {
                    let prevData = JSON.parse(hiddenInput.value);

                    prevData.user_id = userId;

                    prevData = JSON.stringify(prevData);
                    hiddenInput.value = prevData;
                } else {
                    var hiddenInputValues = {
                        'user_id': userId
                    }
                    hiddenInput.value = JSON.stringify(hiddenInputValues);
                }
            })
        }

        function isJSONParseable(data) {
            try {
                JSON.parse(data);
                return true;
            } catch (error) {
                return false;
            }
        }
    </script>
@endsection
