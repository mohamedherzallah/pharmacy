<!DOCTYPE html>
<html lang="en">
<head>
    <base href="../../" />
    <title>Edit Pharmacy</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet">
</head>

<body id="kt_app_body" class="app-default">

<div class="app-root d-flex flex-column flex-root">

    <div class="app-page flex-column flex-column-fluid">

        <div class="app-main flex-column flex-row-fluid">

            <!-- Toolbar -->
            <div class="app-toolbar py-3">
                <div class="container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column">
                        <h1 class="fw-bold fs-3">Edit Pharmacy</h1>
                        <ul class="breadcrumb fw-semibold fs-7">
                            <li class="breadcrumb-item text-muted">Pharmacy Management</li>
                            <li class="breadcrumb-item text-muted">Edit Pharmacy</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="app-content flex-column-fluid">
                <div class="container-xxl">

                    <form
                        action="{{ route('pharmacies.update', $pharmacy->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="form d-flex flex-column gap-10">

                        @csrf
                        @method('PUT')

                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Pharmacy Info -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <h2>Pharmacy Information</h2>
                            </div>

                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label class="required form-label">Pharmacy Name</label>
                                        <input type="text"
                                               name="pharmacy_name"
                                               value="{{ old('pharmacy_name', $pharmacy->pharmacy_name) }}"
                                               class="form-control"
                                               required>
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label class="required form-label">Address</label>
                                        <input type="text"
                                               name="address"
                                               value="{{ old('address', $pharmacy->address) }}"
                                               class="form-control"
                                               required>
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Latitude</label>
                                        <input type="text"
                                               name="latitude"
                                               value="{{ old('latitude', $pharmacy->latitude) }}"
                                               class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Longitude</label>
                                        <input type="text"
                                               name="longitude"
                                               value="{{ old('longitude', $pharmacy->longitude) }}"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <h2>User Account Information</h2>
                            </div>

                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label class="required form-label">User Name</label>
                                        <input type="text"
                                               name="name"
                                               value="{{ old('name', $pharmacy->user->name) }}"
                                               class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label class="required form-label">Phone</label>
                                        <input type="tel"
                                               name="phone"
                                               value="{{ old('phone', $pharmacy->user->phone) }}"
                                               class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Email</label>
                                        <input type="email"
                                               name="email"
                                               value="{{ old('email', $pharmacy->user->email) }}"
                                               class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label class="form-label">Password</label>
                                        <input type="password"
                                               name="password"
                                               class="form-control"
                                               placeholder="Leave empty if unchanged">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="row">

                            <!-- License -->
                            <div class="col-md-6">
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <h2>License Image</h2>
                                    </div>

                                    <div class="card-body text-center">
                                        <div class="image-input image-input-outline"
                                             style="background-image: url('{{ asset('storage/'.$pharmacy->license_image) }}')">
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <input type="file" name="license_image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Logo -->
                            <div class="col-md-6">
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <h2>Pharmacy Logo</h2>
                                    </div>

                                    <div class="card-body text-center">
                                        <div class="image-input image-input-outline"
                                             style="background-image: url('{{ asset('storage/'.$pharmacy->logo) }}')">
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <input type="file" name="logo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Approval -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <h2>Approval Status</h2>
                            </div>

                            <div class="card-body">
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="is_approved"
                                           value="1"
                                        {{ old('is_approved', $pharmacy->is_approved) ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Approved
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-5">
                            <a href="{{ route('pharmacies.index') }}" class="btn btn-light">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update Pharmacy
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

</body>
</html>
