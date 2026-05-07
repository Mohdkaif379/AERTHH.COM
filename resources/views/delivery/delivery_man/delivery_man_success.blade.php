<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Aerthh.com | Application Submitted</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'accent-rose': '#F43F5E',
                        'accent-pink': '#FB7185',
                        'accent-crimson': '#BE123C',
                    },
                    animation: {
                        'check': 'checkBounce 0.5s ease-out',
                    },
                    keyframes: {
                        checkBounce: {
                            '0%': { transform: 'scale(0)', opacity: '0' },
                            '50%': { transform: 'scale(1.15)' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="font-sans bg-gradient-to-br from-[#1a0f14] to-[#0a0508] min-h-screen flex items-center justify-center p-3">

    <!-- Main Success Card - Ultra Compact -->
    <div class="w-full max-w-sm mx-auto">
        
        <!-- Success Container -->
        <div class="bg-[#0F0712] rounded-xl shadow-2xl border border-[#22152a] overflow-hidden">
            
            <!-- Top Progress Bar -->
            <div class="h-0.5 w-full bg-gradient-to-r from-[#F43F5E] via-[#FB7185] to-[#F43F5E]"></div>
            
            <!-- Header with Logo - Ultra Compact -->
            <div class="p-3 pb-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <div class="bg-black/40 backdrop-blur rounded-xl border border-[#F43F5E]/30">
                            <img src="{{asset('logo.webp')}}" alt="Aerthh Logo" class="w-[40px] h-[40px] rounded-xl">
                        </div>
                        <div>
                            <h1 class="text-sm font-bold text-white">Aerthh <span class="text-[#FB7185]">Delivery</span></h1>
                            <p class="text-gray-500 text-[7px]">Partner Portal</p>
                        </div>
                    </div>
                    <!-- <div class="bg-[#F43F5E]/10 px-1.5 py-0.5 rounded-full border border-[#F43F5E]/30">
                        <span class="text-[#FB7185] text-[7px] font-semibold">4/4</span>
                    </div> -->
                </div>
            </div>
            
            <!-- Success Icon & Message - Ultra Compact -->
            <div class="text-center py-3">
                <div class="relative inline-block">
                    <div class="relative w-12 h-12 mx-auto bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center shadow-md animate-check">
                        <i class="fas fa-check text-white text-base"></i>
                    </div>
                </div>
                
                <h2 class="text-sm font-bold text-white mt-1.5">Application Submitted!</h2>
                <p class="text-gray-400 text-[9px] mt-0.5">Application received successfully</p>
            </div>
            
            <!-- Application ID Card - Ultra Compact -->
            <div class="px-3">
                <div class="bg-black/30 rounded-lg p-2 border border-[#22152a]">
                    <div class="flex justify-between items-center mb-1.5 pb-1 border-b border-[#22152a]">
                        <span class="text-gray-400 text-[8px]">App ID</span>
                        <span class="text-[#FB7185] font-mono font-semibold text-[9px]">DM{{ $latestDeliveryMan->id ?? '12345' }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-1.5 pb-1 border-b border-[#22152a]">
                        <span class="text-gray-400 text-[8px]">Submitted</span>
                        <span class="text-white text-[8px]">{{ $latestDeliveryMan?->created_at?->format('M d, Y') ?? 'Dec 15, 2024' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-[8px]">Status</span>
                        <span class="bg-yellow-500/20 text-yellow-400 text-[8px] px-1.5 py-0.5 rounded-full flex items-center gap-0.5">
                            <i class="fas fa-clock text-[6px]"></i> Pending
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Next Steps Section - Ultra Compact -->
            <div class="px-3 mt-3">
                <h3 class="text-white text-[9px] font-semibold mb-1.5 flex items-center gap-1">
                    <i class="fas fa-list-check text-[#FB7185] text-[8px]"></i> Next Steps
                </h3>
                <div class="space-y-1.5">
                    <div class="flex items-center gap-1.5 bg-black/20 rounded-lg p-1.5">
                        <div class="w-4 h-4 rounded-full bg-[#F43F5E]/20 flex items-center justify-center">
                            <span class="text-[#FB7185] text-[7px] font-bold">1</span>
                        </div>
                        <div>
                            <p class="text-white text-[8px] font-medium">Admin Review</p>
                            <p class="text-gray-500 text-[6px]">Team will verify documents</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 bg-black/20 rounded-lg p-1.5">
                        <div class="w-4 h-4 rounded-full bg-[#F43F5E]/20 flex items-center justify-center">
                            <span class="text-[#FB7185] text-[7px] font-bold">2</span>
                        </div>
                        <div>
                            <p class="text-white text-[8px] font-medium">KYC Verification</p>
                            <p class="text-gray-500 text-[6px]">Aadhaar, License & RC check</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 bg-black/20 rounded-lg p-1.5">
                        <div class="w-4 h-4 rounded-full bg-[#F43F5E]/20 flex items-center justify-center">
                            <span class="text-[#FB7185] text-[7px] font-bold">3</span>
                        </div>
                        <div>
                            <p class="text-white text-[8px] font-medium">Onboarding Call</p>
                            <p class="text-gray-500 text-[6px]">Training after approval</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estimated Timeline - Ultra Compact -->
            <div class="px-3 mt-2">
                <div class="bg-gradient-to-r from-[#F43F5E]/10 to-transparent rounded-lg p-1.5 border-l-2 border-[#FB7185]">
                    <div class="flex items-start gap-1.5">
                        <i class="fas fa-hourglass-half text-[#FB7185] text-[10px] mt-0"></i>
                        <div>
                            <p class="text-white text-[8px] font-semibold">24-48 hours processing</p>
                            <p class="text-gray-400 text-[6px]">SMS/Email notification on approval</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Support - Ultra Compact -->
            <div class="px-3 pb-3 pt-3">
                <div class="text-center border-t border-[#22152a] pt-2">
                    <p class="text-gray-500 text-[7px]">
                        <i class="fas fa-headset text-[#FB7185] mr-1 text-[6px]"></i> Need help? 
                        <a href="#" class="text-[#FB7185] hover:underline">Contact Support</a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Small Footer Note -->
        <div class="text-center mt-2 text-[7px] text-gray-500">
            <i class="fas fa-envelope mr-0.5"></i> Check email for confirmation
        </div>
    </div>
</body>

</html>