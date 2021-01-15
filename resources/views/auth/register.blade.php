@extends('layouts.auth')

@section('title')

 TechStore Sign Up page
    
@endsection

@section('content')

<div class="page-content page-auth" id="register">
    <div class="section-store-auth" data-aos="fade-up">
      <div class="container">
        <div class="row align-items-center justify-content-center row-login">
          <div class="col-lg-4">
            <h2>Mulai Jual beli dengan cara terbaru</h2>
            {{-- input name --}}
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-group">
                <label for="">Full Names</label>
                <input id="name"
                  v-model="name"
                  type="text" 
                  class="form-control @error('name') is-invalid @enderror" 
                  name="name" 
                  value="{{ old('name') }}" 
                  required autocomplete="name" 
                  autofocus>
                  @error('name')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              {{-- input email --}}
              <div class="form-group">
                <label for="">Email Address</label>
                <input id="email"
                  v-model="email"
                  @change="checkEmail()"
                  type="email" 
                  class="form-control @error('email') is-invalid @enderror"
                  :class ="{'is_invalid' : this.email_unavailable }"
                  name="email" 
                  value="{{ old('email') }}" 
                  required 
                  autocomplete="email">
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                     </span>
                  @enderror
              </div>
              {{-- input password --}}
              <div class="form-group">
                <label for="">Password</label>
                <input id="password" 
                type="password" 
                class="form-control @error('password') is-invalid @enderror" 
                name="password" 
                required 
                autocomplete="new-password">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
                {{-- password konfirmasi --}}
              <div class="form-group">
                <label for="">Konfirmasi Password</label>
                <input id="password-confirm" 
                type="password" 
                class="form-control @error('password_confirmation') is-invalid @enderror" 
                name="password_confirmation" 
                required 
                autocomplete="new-password">
                  @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="form-group">
                  <label>Store</label>
                  <p class="text-muted">
                    Apakah anda juga ingin membuka toko?
                  </p>
                  <div
                    class="custom-control custom-radio custom-control-inline"
                  >
                    <input
                      class="custom-control-input"
                      type="radio"
                      name="is_store_open"
                      id="openStoreTrue"
                      v-model="is_store_open"
                      :value="true"
                    />
                    <label class="custom-control-label" for="openStoreTrue"
                      >Iya, boleh</label>
                  </div>
                  <div
                    class="custom-control custom-radio custom-control-inline">
                    <input
                      class="custom-control-input"
                      type="radio"
                      name="is_store_open"
                      id="openStoreFalse"
                      v-model="is_store_open"
                      :value="false"
                    />
                    <label
                      class="custom-control-label"
                      for="openStoreFalse"
                      >Tidak, Terimakasih</label>
                  </div>
                </div>
              <div class="form-group" v-if="is_store_open">
                <label for="">Nama Toko</label>
                  <input type="text" 
                    v-model="store_name"
                    id="store_name"
                    class="form-control @error('store_name') is-invalid @enderror" 
                    name="store_name"
                    required
                    autocomplete
                    autofocus>
                    @error('store_name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
              </div>
              <div class="form-group" v-if="is_store_open">
                <label for="">Kategori</label>
                <select name="category" class="form-control" id="">       
                  @foreach ($categories as $category)
                    <option option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <button
                type="submit"
                class="btn btn-success btn-block mt-4"
                :disabled="this.email_unavailable"
              >
                Sign Up Now</button>
              
              <a href="{{ route('login') }}" class="btn btn-signup btn-block mt-2">
                Back to Sign In
                </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      Vue.use(Toasted);

      var register = new Vue({
        el: "#register",
        mounted() {
          AOS.init();
          
        },
        methods: {
          // validasi email telah ada atau belum
          checkEmail: function(){
            var self = this;
            axios.get('{{ route('api-register-check') }}',{
                params:{
                  email: this.email
                }
            })
              .then(function (response) {
                if(response.data == 'Available') {
                  self.$toasted.show(
                      "Email anda tersedia! silakan lanjut", 
                    {
                      position: "top-center",
                      className: "rounded",
                      duration: 1000,
                    }
                  );
                
                }else {
                  self.email_unavailable = false ;
                  self.$toasted.error(
                    "Email anda sudah terdaftar.", 
                  {
                    position: "top-center",
                    className: "rounded",
                    duration: 1000,
                  });
                  self.email_unavailable = true;
                }
              
                console.log(response);
                }
              );
          }
        },
        data() {
          return {
          name: "",
          email: "",
          is_store_open: true,
          store_name: " ",
          email_unavailable:false
          }
        },
      });
    </script>

@endpush
