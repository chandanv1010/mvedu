@extends('frontend.homepage.layout')

@section('content')
<style>
    :root {
        --primary-404: #008DC2;
        --secondary-404: #EE1D23;
        --bg-gradient: linear-gradient(135deg, #f8fafd 0%, #eef2f7 100%);
        --glass-bg: rgba(255, 255, 255, 0.8);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .error-404-section {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-gradient);
        padding: 60px 20px;
        position: relative;
        overflow: hidden;
        font-family: 'Quicksand', sans-serif;
    }

    /* Background Decorations */
    .error-bg-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        z-index: 0;
        opacity: 0.4;
    }
    .shape-1 {
        width: 300px;
        height: 300px;
        background: var(--primary-404);
        top: -100px;
        right: -50px;
        animation: float-slow 10s infinite alternate;
    }
    .shape-2 {
        width: 400px;
        height: 400px;
        background: #00B9FF;
        bottom: -150px;
        left: -100px;
        animation: float-slow 15s infinite alternate-reverse;
    }

    @keyframes float-slow {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(30px, 40px) scale(1.1); }
    }

    .error-404-card {
        max-width: 900px;
        width: 100%;
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 80px 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .error-illustration {
        position: relative;
        margin-bottom: 40px;
    }

    .error-404-number {
        font-size: clamp(120px, 15vw, 200px);
        font-weight: 900;
        line-height: 0.8;
        background: linear-gradient(135deg, var(--primary-404), #00B9FF);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
        font-family: 'Asap', sans-serif;
        letter-spacing: -5px;
        display: inline-block;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .error-404-title {
        font-size: clamp(24px, 5vw, 42px);
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 20px;
        font-family: 'Asap', sans-serif;
    }

    .error-404-desc {
        font-size: 18px;
        color: #4a5568;
        max-width: 600px;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .error-actions {
        display: flex;
        gap: 20px;
        margin-bottom: 50px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn-error {
        padding: 16px 32px;
        border-radius: 16px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 16px;
    }

    .btn-error-primary {
        background: linear-gradient(135deg, var(--primary-404), #00B9FF);
        color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 141, 194, 0.3);
    }

    .btn-error-primary:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(0, 141, 194, 0.4);
        color: white;
    }

    .btn-error-secondary {
        background: white;
        color: var(--primary-404);
        border: 2px solid #e2e8f0;
    }

    .btn-error-secondary:hover {
        transform: translateY(-5px);
        background: #f7fafc;
        border-color: var(--primary-404);
    }

    .error-404-search {
        width: 100%;
        max-width: 500px;
        margin-top: 20px;
        border-top: 1px solid #e2e8f0;
        padding-top: 40px;
    }

    .search-title {
        font-size: 16px;
        color: #718096;
        margin-bottom: 20px;
        display: block;
    }

    .error-search-form {
        position: relative;
        display: flex;
    }

    .error-search-input {
        flex: 1;
        padding: 16px 24px;
        padding-right: 60px;
        border-radius: 16px;
        border: 2px solid #e2e8f0;
        font-size: 16px;
        outline: none;
        transition: all 0.3s ease;
        background: white;
    }

    .error-search-input:focus {
        border-color: var(--primary-404);
        box-shadow: 0 0 0 4px rgba(0, 141, 194, 0.1);
    }

    .error-search-submit {
        position: absolute;
        right: 8px;
        top: 8px;
        bottom: 8px;
        width: 48px;
        background: var(--primary-404);
        color: white;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .error-search-submit:hover {
        background: #006a9a;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .error-404-card {
            padding: 60px 20px;
            border-radius: 20px;
        }
        .error-actions {
            flex-direction: column;
            width: 100%;
        }
        .btn-error {
            width: 100%;
            justify-content: center;
        }
    }

    /* Small animated objects */
    .floating-icon {
        position: absolute;
        font-size: 24px;
        color: var(--primary-404);
        opacity: 0.2;
        z-index: 0;
    }
    .icon-1 { top: 20%; left: 10%; animation: float-icon 6s infinite; }
    .icon-2 { top: 70%; right: 15%; animation: float-icon 8s infinite reverse; }
    .icon-3 { bottom: 10%; left: 20%; animation: float-icon 7s infinite; }

    @keyframes float-icon {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(20deg); }
    }
</style>

<div class="error-404-section">
    <!-- Background Shapes -->
    <div class="error-bg-shape shape-1"></div>
    <div class="error-bg-shape shape-2"></div>
    
    <!-- Floating Icons -->
    <i class="fa fa-graduation-cap floating-icon icon-1"></i>
    <i class="fa fa-book floating-icon icon-2"></i>
    <i class="fa fa-pencil-alt floating-icon icon-3"></i>

    <div class="error-404-card wow fadeInUp" data-wow-duration="1s">
        <div class="error-illustration">
            <h1 class="error-404-number">404</h1>
        </div>
        
        <h2 class="error-404-title">Ối! Trang này không tồn tại</h2>
        <p class="error-404-desc">
            Có vẻ như đường dẫn này đã bị hỏng hoặc trang web đã được chuyển sang một địa chỉ mới. Đừng lo lắng, bạn có thể quay lại trang chủ hoặc tìm kiếm nội dung khác bên dưới.
        </p>

        <div class="error-actions">
            <a href="{{ route('home.index') }}" class="btn-error btn-error-primary">
                <i class="fa fa-home"></i>
                Về trang chủ
            </a>
            <a href="javascript:history.back()" class="btn-error btn-error-secondary">
                <i class="fa fa-arrow-left"></i>
                Quay lại
            </a>
        </div>

        <div class="error-404-search">
            <span class="search-title">Bạn đang tìm kiếm gì đó?</span>
            <form class="error-search-form" action="{{ route('product.catalogue.search') }}" method="GET">
                <input 
                    type="text" 
                    name="keyword" 
                    class="error-search-input" 
                    placeholder="Tìm kiếm ngành học, học bổng..."
                    required
                >
                <button type="submit" class="error-search-submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
