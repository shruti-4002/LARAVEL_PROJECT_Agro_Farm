@extends('layouts.app')

@section('title', 'Farmer Advisor - AgriMandi')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap');

    
        @keyframes containerEntrance {
            from { opacity: 0; transform: scale(0.98) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes popIn {
            0% { opacity: 0; transform: scale(0.8) translateY(10px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes botFloat {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

       
        .colorful-wrapper {
            font-family: 'Inter', sans-serif;
            animation: containerEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
            margin-top: 10px;
            background: linear-gradient(-45deg, #f0fdf4, #f5f3ff, #ecfeff, #f0fdf4);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite, containerEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
            padding: 24px;
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

     
        .vibrant-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: 24px;
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 10px 30px -10px rgba(4, 120, 87, 0.08);
            margin-bottom: 24px;
        }

        .header-title-block h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 2.4rem;
            background: linear-gradient(135deg, #059669 0%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.03em;
            margin: 4px 0;
        }

        .vibrant-badge {
            background: linear-gradient(90deg, #4f46e5 0%, #06b6d4 100%);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 6px 16px;
            border-radius: 100px;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

    
        .vibrant-grid {
            display: grid;
            grid-template-columns: 2.6fr 1.1fr;
            gap: 24px;
            align-items: start;
        }

      
        .vibrant-chat-card {
            background: #ffffff;
            border: 1px solid rgba(16, 185, 129, 0.15);
            border-radius: 28px;
            box-shadow: 0 20px 50px -15px rgba(15, 23, 42, 0.06);
            display: flex;
            flex-direction: column;
            height: 620px;
            overflow: hidden;
            position: relative;
        }

        .chat-top-bar {
            padding: 18px 24px;
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 12px;
        }

      
        .wallpaper-scroller {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
           
            background-color: #f4f7f6;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%2310b981' fill-opacity='0.04'%3E%3Cpath fill-rule='evenodd' d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm1-61c3.16 0 5-1.84 5-5s-1.84-5-5-5-5 1.84-5 5 1.84 5 5 5zm29 57c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM25 54c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm14 7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z'/%3E%3C/g%3E%3C/svg%3E");
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

  
        .msg-container {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            animation: popIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        .msg-container.farmer-row {
            flex-direction: row-reverse;
        }

        .avatar-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .avatar-circle.bot { background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); }
        .avatar-circle.user { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }

        .vibrant-bubble {
            max-width: 68%;
            padding: 14px 20px;
            font-size: 0.98rem;
            line-height: 1.6;
            word-wrap: break-word;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.03);
        }

        .farmer .vibrant-bubble {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border-radius: 22px 22px 4px 22px;
            box-shadow: 0 8px 20px -6px rgba(16, 185, 129, 0.4);
        }

        .advisor .vibrant-bubble {
            background-color: #ffffff;
            color: #1e293b;
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 22px 22px 22px 4px;
        }

     
        .chatbot-image-box {
            text-align: center;
            margin: auto;
            max-width: 400px;
            padding: 20px;
        }

        .bot-artwork {
            width: 150px;
            height: 150px;
            margin: 0 auto 24px auto;
            animation: botFloat 4s ease-in-out infinite;
        }

        /* Modern Colorful Input Controller bar */
        .vibrant-footer-deck {
            padding: 20px 24px;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
        }

        .vibrant-pill-form {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            padding: 6px 8px 6px 20px;
            transition: all 0.3s ease;
        }

        .vibrant-pill-form:focus-within {
            border-color: #4f46e5;
            background: #ffffff;
            box-shadow: 0 0 0 5px rgba(79, 70, 229, 0.12);
        }

        .vibrant-textarea {
            flex: 1;
            min-height: 44px;
            max-height: 44px;
            background: transparent;
            border: none;
            outline: none;
            font-family: inherit;
            font-size: 1rem;
            color: #0f172a;
            resize: none;
            padding: 10px 0;
        }

        .vibrant-submit-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            color: #ffffff;
            border: none;
            height: 46px;
            padding: 0 26px;
            border-radius: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .vibrant-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.45);
        }

        /* Sidebar Glass Hub */
        .vibrant-sidebar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 28px;
            padding: 28px;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.04);
        }

        .back-dashboard-btn {
            width: 100%;
            background: #ffffff;
            color: #4f46e5;
            border: 2px solid #e0e7ff;
            padding: 14px;
            border-radius: 16px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.05);
        }

        .back-dashboard-btn:hover {
            background: #4f46e5;
            color: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.25);
        }

        .micro-scroll::-webkit-scrollbar { width: 5px; }
        .micro-scroll::-webkit-scrollbar-track { background: transparent; }
        .micro-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
    </style>

    <div class="colorful-wrapper">
        
        <header class="vibrant-header">
            <div class="header-title-block">
                <span class="vibrant-badge">✨ Smart Krishi Ecosystem</span>
                <h1>Market Chat</h1>
                <p style="color: #475569; font-size: 1rem; margin: 4px 0 0 0;">Ask about crop pricing, local rates, stock planning, and selling timing.</p>
            </div>
            <div>
                <a class="back-dashboard-btn" href="{{ route('farmer.dashboard') }}">
                    🎒 Back to Dashboard
                </a>
            </div>
        </header>

        <div class="vibrant-grid">
            
            <div class="vibrant-chat-card">
                <div class="chat-top-bar">
                    <div style="width: 10px; height: 10px; background-color: #22c55e; border-radius: 50%; box-shadow: 0 0 12px #22c55e;"></div>
                    <span style="font-weight: 700; color: #1e293b; font-size: 1rem;">Mandi AI Expert Advisor</span>
                </div>

                <div class="wallpaper-scroller micro-scroll" id="vibrantScroller">
                    @forelse($messages as $message)
                        <div class="msg-container {{ $message['role'] === 'farmer' ? 'farmer-row farmer' : 'advisor-row advisor' }}">
                            <div class="avatar-circle {{ $message['role'] === 'farmer' ? 'user' : 'bot' }}">
                                {{ $message['role'] === 'farmer' ? '👨‍🌾' : '🤖' }}
                            </div>
                            <div class="vibrant-bubble">
                                {{ $message['text'] }}
                            </div>
                        </div>
                    @empty
                        <div class="chatbot-image-box">
                            <div class="bot-artwork">
                                <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="botGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#6366f1" />
                                            <stop offset="100%" stop-color="#06b6d4" />
                                        </linearGradient>
                                        <linearGradient id="leafGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#10b981" />
                                            <stop offset="100%" stop-color="#059669" />
                                        </linearGradient>
                                    </defs>
                                    <circle cx="100" cy="100" r="80" fill="url(#botGrad)" fill-opacity="0.15" />
                                    <path d="M100 60V35" stroke="url(#botGrad)" stroke-width="5" stroke-linecap="round"/>
                                    <path d="M100 35C115 35 125 20 125 20C125 20 110 25 100 35Z" fill="url(#leafGrad)"/>
                                    <rect x="50" y="60" width="100" height="80" rx="30" fill="url(#botGrad)" />
                                    <rect x="62" y="72" width="76" height="56" rx="18" fill="#1e1b4b" />
                                    <circle cx="85" cy="96" r="8" fill="#22d3ee" />
                                    <circle cx="115" cy="96" r="8" fill="#22d3ee" />
                                    <path d="M82 92H88" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M112 92H118" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M92 112C95 115 105 115 108 112" stroke="#22d3ee" stroke-width="3" stroke-linecap="round"/>
                                    <rect x="42" y="85" width="8" height="30" rx="4" fill="#6366f1" />
                                    <rect x="150" y="85" width="8" height="30" rx="4" fill="#6366f1" />
                                </svg>
                            </div>
                            <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; color: #1e293b; margin: 0 0 8px 0; font-size: 1.3rem;">Namaste! Main Hoon Aapka Mandi Bot</h3>
                            <p style="color: #64748b; font-size: 0.95rem; margin: 0; line-height: 1.6;">Apni fasal ki sahi keemat, punjab-haryana rates ya market selling strategy ke baare mein yahan bejhijhak poochein!</p>
                        </div>
                    @endforelse
                </div>

                <div class="vibrant-footer-deck">
                    <form method="post" action="{{ route('farmer.advisor.ask') }}">
                        @csrf
                        <div class="vibrant-pill-form">
                            <textarea class="vibrant-textarea" id="vibrantMessageInput" name="message" maxlength="800" required placeholder="Kuch bhi sawaal poochein... (e.g., Aaj ka wheat market price kya chal raha hai?)"></textarea>
                            <button class="vibrant-submit-btn" type="submit">
                                Send Message 🚀
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="vibrant-sidebar">
                <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: #1e293b; font-size: 1.25rem; margin: 0 0 12px 0;">⚡ Live Intelligence</h3>
                <p style="font-size: 0.92rem; color: #64748b; line-height: 1.6; margin: 0 0 24px 0;">
                    Yeh active console live data aur algorithms ko filter karke aapko top agricultural advisor updates deta hai.
                </p>

                <div style="display: flex; flex-direction: column; gap: 16px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                    <div>
                        <span style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 6px; letter-spacing: 0.05em;">AI Processor Engine</span>
                        <div style="font-size: 0.88rem; font-weight: 600; color: #4f46e5; background: #f5f3ff; padding: 12px 16px; border-radius: 14px; border: 1px solid #ddd6fe; word-break: break-all;">
                            {{ config('services.openai.model') }}
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
          
            const activeScroll = document.getElementById('vibrantScroller');
            if (activeScroll) {
                activeScroll.scrollTop = activeScroll.scrollHeight;
            }
            
            
            const chatBoxInput = document.getElementById('vibrantMessageInput');
            if(chatBoxInput) {
                chatBoxInput.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' && !event.shiftKey) {
                        event.preventDefault();
                        if(this.value.trim() !== "") {
                            this.form.submit();
                        }
                    }
                });
            }
        });
    </script>
@endsection