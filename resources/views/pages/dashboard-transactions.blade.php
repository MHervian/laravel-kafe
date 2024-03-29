@extends('layouts.dashboard')

@section('title')
    Store Dashboard Transaction
@endsection

@section('content')
<!-- Section Content -->
<div
  class="section-content section-dashboard-home"
  data-aos="fade-up"
>
  <div class="container-fluid">
    <div class="dashboard-heading">
      <h2 class="dashboard-title">Transactions</h2>
      <p class="dashboard-subtitle">
        List of purchase of orders.
      </p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-12 mt-2">
          <ul
            class="nav nav-pills mb-3"
            id="pills-tab"
            role="tablist"
          >
          @if (Auth::user()->getAttribute('roles') === 'ADMIN')
            <li class="nav-item" role="presentation">
              <a
                class="nav-link active"
                id="pills-home-tab"
                data-toggle="pill"
                href="#pills-home"
                role="tab"
                aria-controls="pills-home"
                aria-selected="true"
                >Menu yg Terjual</a
              >
            </li>
          @endif
          @if (Auth::user()->getAttribute('roles') === 'USER')
            <li class="nav-item" role="presentation">
              <a
                class="nav-link"
                id="pills-profile-tab"
                data-toggle="pill"
                href="#pills-profile"
                role="tab"
                aria-controls="pills-profile"
                aria-selected="true"
                >Menu yg dibeli</a
              >
            </li>
          @endif
          </ul>
          <div class="tab-content" id="pills-tabContent">
            @if (Auth::user()->getAttribute('roles') === 'ADMIN')
            <div
              class="tab-pane fade show active"
              id="pills-home"
              role="tabpanel"
              aria-labelledby="pills-home-tab"
            >
              @foreach ($sellTransactions as $transaction)
                  <a
                    href="{{ route('dashboard-transaction-details', $transaction->id) }}"
                    class="card card-list d-block"
                  >
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-1">
                          <img
                            src="{{ asset('uploads/'.$transaction->product->galleries->first()->photos) }}"
                            class="w-50"
                          />
                        </div>
                        <div class="col-md-4">
                          {{ $transaction->product->name }}
                        </div>
                        <div class="col-md-3">
                          {{ $transaction->product->user->store_name }}
                        </div>
                        <div class="col-md-3">
                          {{ $transaction->created_at }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">
                          <img
                            src="/images/dashboard-arrow-right.svg"
                            alt=""
                          />
                        </div>
                      </div>
                    </div>
                  </a>
              @endforeach
            </div>
            @endif
            @if (Auth::user()->getAttribute('roles') === 'USER')
            <div
              class="tab-pane fade show active"
              id="pills-profile"
              role="tabpanel"
              aria-labelledby="pills-profile-tab"
            >
              @foreach ($buyTransactions as $transaction)
                  <a
                    href="{{ route('dashboard-transaction-details', $transaction->id) }}"
                    class="card card-list d-block"
                  >
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-1">
                          @if (!empty($transaction->product->galleries->first()))
                          <img
                            src="{{ asset('uploads/'.$transaction->product->galleries->first()->photos ?? '') }}"
                            class="w-50"
                          />
                          @else 
                          <span class="cart-image"
                            style="display: block; background-color: lightgray; width: 50px; height: 50px;"
                          ></span>
                          @endif
                        </div>
                        <div class="col-md-2">
                          {{ $transaction->product->name }}
                        </div>
                        <div class="col-md-2">
                          {{ $transaction->amount }} Order(s)
                        </div>
                        <div class="col-md-2">
                          @if ($transaction->shipping_status === 'SUCCESS') 
                            <span class="text-success">{{ $transaction->shipping_status }}</span>
                          @elseif ($transaction->shipping_status === 'COOKING') 
                            <span class="text-primary">{{ $transaction->shipping_status }}</span>
                          @else 
                            <span class="text-danger">{{ $transaction->shipping_status }}</span>
                          @endif
                        </div>
                        
                        {{--
                        <div class="col-md-3">
                          {{ $transaction->product->user->store_name }}
                        </div>
                        --}}

                        <div class="col-md-3">
                          {{ $transaction->created_at }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">
                          <img
                            src="/images/dashboard-arrow-right.svg"
                            alt=""
                          />
                        </div>
                      </div>
                    </div>
                  </a>
              @endforeach
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection