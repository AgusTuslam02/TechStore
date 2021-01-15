@extends('layouts.app')

@section('title')

 TechStore Details Page
    
@endsection
@section('content')
  <div class="page-content page-details">
      <section
        class="store-breadcrumbs"
        data-aos="fade-down"
        data-aos-delay="100"
      >
        <div class="container">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="./index.html" class="">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Product Details</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-gallery mb-3" id="gallery">
        <div class="container">
          <div class="row">
            <div class="col-lg-8" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img
                  :src="photos[activePhoto].url"
                  :key="photos[activePhoto].id"
                  class="w-100 main-image"
                  alt=""
                />
              </transition>
            </div>
            <div class="col-lg-2">
              <div class="row">
                <div
                  class="col-3 col-lg-12 mt-2 mt-lg-0"
                  v-for="(photo, index) in photos"
                  :key="photo.id"
                  data-aos="zoom-in"
                  data-aos-delay="100"
                >
                  <a href="#" @click="changeActive(index)">
                    <img
                      :src="photo.url"
                      class="w-100 thumbnail-image"
                      :class="{active: index == activePhoto}"
                      alt=""
                    />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="store-details-container" data-aos="fade-up">
        <!--Page Heading-->
        <section class="store-heading">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <h1>{{ $product->name }}</h1>
                <div class="owner">By {{ $product->user->store_name }}</div>
                <div class="price">Rp.{{ number_format($product->price) }}</div>
              </div>
              <div class="col-lg-2" data-aos="zoom-in">
                @auth
                <form action="{{ route('details-add', $product->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <button
                    type="submit"
                    class="btn btn-success nav-link px-4 text-white btn-block mb-3"
                  >
                  Add to Cart</button>
                </form>
                
                @else
                <a
                  href="{{ route('login') }}"
                  class="btn btn-success nav-link px-4 text-white btn-block mb-3"
                >
                sign to add</a>
                @endauth
                
              </div>
            </div>
          </div>
        </section>
        <!--store description-->
        <section store-description>
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8">
                {!! $product->description !!}
              </div>
            </div>
          </div>
        </section>

        <!-- store Review -->
        <section class="store-review">
          <div class="container">
            <div class="row">
              <div class="col-12 col-lg-8 mb-3">
                <h5>Customer Review (3)</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-lg-8">
                <ul class="list-unstyled">
                  <li class="media">
                    <img
                      src="/images/cust-review.png"
                      alt=""
                      class="mr-3 rounded-circle"
                    />
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Agus Tuslam</h5>
                      Do sit excepteur aliqua dolor velit nostrud dolor in non.
                    </div>
                  </li>
                  <li class="media">
                    <img
                      src="/images/cust-review.png"
                      alt=""
                      class="mr-3 rounded-circle"
                    />
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">Adhtya laksana</h5>
                      Aliquip laboris proident ex proident nisi anim consequat
                      cupidatat sint ea. Dolore consequat quis amet in eiusmod
                      irure anim proident veniam duis laborum dolore pariatur
                      reprehenderit. Velit quis ipsum irure cillum magna enim
                      consectetur irure consequat cupidatat nulla consequat.
                      Occaecat ipsum adipisicing voluptate aute laborum laboris
                      laborum nostrud. Elit esse Lorem consequat irure commodo
                      eu eiusmod incididunt.
                    </div>
                  </li>
                  <li class="media">
                    <img
                      src="/images/cust-review.png"
                      alt=""
                      class="mr-3 rounded-circle"
                    />
                    <div class="media-body">
                      <h5 class="mt-2 mb-1">irva Muhriza</h5>
                      Incididunt voluptate duis consequat enim ad consectetur
                      sunt ut.
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
           @foreach($product->galleries as $gallery)
           {
              id: {{ $gallery->id }},
              url: "{{ Storage::url($gallery->photos) }}",
            },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
   <script src="../script/navbar-scroll.js"></script>
@endpush