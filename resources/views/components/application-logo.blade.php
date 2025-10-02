<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Background Circle -->
    <circle cx="100" cy="100" r="95" fill="url(#agriGradient)" opacity="0.1"/>
    
    <!-- Gradient Definitions -->
    <defs>
        <linearGradient id="agriGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#16a34a;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:1" />
        </linearGradient>
        <linearGradient id="harvestGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#f59e0b;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#fbbf24;stop-opacity:1" />
        </linearGradient>
    </defs>
    
    <!-- Wheat/Grain Stalks (Left side) -->
    <g transform="translate(40, 60)">
        <!-- Stalk 1 -->
        <path d="M 5 80 Q 5 40 10 20" stroke="#16a34a" stroke-width="3" fill="none" stroke-linecap="round"/>
        <ellipse cx="10" cy="15" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="8" cy="22" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="12" cy="22" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="10" cy="29" rx="4" ry="6" fill="#f59e0b"/>
        
        <!-- Stalk 2 -->
        <path d="M 20 80 Q 20 35 20 15" stroke="#16a34a" stroke-width="3" fill="none" stroke-linecap="round"/>
        <ellipse cx="20" cy="10" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="18" cy="17" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="22" cy="17" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="20" cy="24" rx="4" ry="6" fill="#f59e0b"/>
        
        <!-- Stalk 3 -->
        <path d="M 35 80 Q 35 45 30 25" stroke="#15803d" stroke-width="3" fill="none" stroke-linecap="round"/>
        <ellipse cx="30" cy="20" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="28" cy="27" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="32" cy="27" rx="4" ry="6" fill="#fbbf24"/>
        <ellipse cx="30" cy="34" rx="4" ry="6" fill="#f59e0b"/>
    </g>
    
    <!-- Shopping Cart integrated with barn (Right side) -->
    <g transform="translate(120, 70)">
        <!-- Cart Body -->
        <rect x="5" y="25" width="35" height="25" rx="3" fill="url(#agriGradient)" opacity="0.9"/>
        
        <!-- Cart Grid -->
        <line x1="10" y1="25" x2="10" y2="50" stroke="white" stroke-width="1.5" opacity="0.5"/>
        <line x1="20" y1="25" x2="20" y2="50" stroke="white" stroke-width="1.5" opacity="0.5"/>
        <line x1="30" y1="25" x2="30" y2="50" stroke="white" stroke-width="1.5" opacity="0.5"/>
        <line x1="5" y1="35" x2="40" y2="35" stroke="white" stroke-width="1.5" opacity="0.5"/>
        
        <!-- Cart Handle -->
        <path d="M 5 25 L 0 10 L 8 10" stroke="#16a34a" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
        
        <!-- Wheels -->
        <circle cx="15" cy="55" r="5" fill="#166534" stroke="#15803d" stroke-width="2"/>
        <circle cx="30" cy="55" r="5" fill="#166534" stroke="#15803d" stroke-width="2"/>
        <circle cx="15" cy="55" r="2" fill="white"/>
        <circle cx="30" cy="55" r="2" fill="white"/>
    </g>
    
    <!-- Center Animal Icon (Simplified Cow/Livestock) -->
    <g transform="translate(85, 95)">
        <ellipse cx="15" cy="15" rx="12" ry="10" fill="url(#harvestGradient)" opacity="0.9"/>
        <circle cx="10" cy="12" r="2.5" fill="white"/>
        <circle cx="20" cy="12" r="2.5" fill="white"/>
        <circle cx="10" cy="12" r="1" fill="#78350f"/>
        <circle cx="20" cy="12" r="1" fill="#78350f"/>
        <path d="M 12 18 Q 15 20 18 18" stroke="#78350f" stroke-width="1.5" fill="none" stroke-linecap="round"/>
    </g>
    
    <!-- Leaves accent (top right) -->
    <g transform="translate(140, 40)">
        <path d="M 0 0 Q 10 -5 15 5 Q 10 15 0 10 Z" fill="#22c55e" opacity="0.7"/>
        <path d="M 15 5 Q 25 0 30 10 Q 25 20 15 15 Z" fill="#16a34a" opacity="0.7"/>
    </g>
</svg>
