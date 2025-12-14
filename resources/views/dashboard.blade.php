@extends('layouts.admin')

@section('title', 'لوحة التحكم - الإحصائيات')

@section('content')
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-md-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10" style="background-color: #F1416C;">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $stats['total_users'] }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">إجمالي المستخدمين</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10" style="background-color: #009ef7;">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $stats['total_pharmacies'] }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">الصيدليات المسجلة</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10" style="background-color: #50cd89;">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $stats['total_medicines'] }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">الأدوية المتاحة</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-100 mb-5 mb-xl-10" style="background-color: #7239ea;">
                <div class="card-header pt-5">
                    <div class="card-title d-flex flex-column">
                        <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">${{ number_format($stats['total_revenue'], 2) }}</span>
                        <span class="text-white opacity-75 pt-1 fw-semibold fs-6">إجمالي الإيرادات</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">إجراءات سريعة</h3>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('users.index') }}" class="btn btn-dark">إدارة المستخدمين</a>
                <a href="{{ route('pharmacies.index') }}" class="btn btn-primary">إدارة الصيدليات</a>
                <a href="{{ route('orders.index') }}" class="btn btn-success">عرض الطلبات</a>
                <a href="{{ route('pharmacies.pending') }}" class="btn btn-warning">طلبات الانضمام</a>
            </div>
        </div>
    </div>
@endsection
