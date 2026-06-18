<?php
// Dynamic PHP SEO Pre-rendering Logic
require_once 'database.php';

$seoTitle = "AweshEditz - Download MOD APK Games & Apps";
$seoDesc = "AweshEditz is the ultimate hub to download 100% working MOD APK games, premium unlocked Android apps, and premium configurations free.";
$seoKeywords = "awesheditz, awesh editz, mod apk, awesh edits, Capcut, capcut pro, premium apk, download hack games, android mod games, unlocked apps premium, safe mod apks, ad free apks, free android games";
$seoImage = "https://awesheditz.eu.cc/icon.png";
$canonicalUrl = "https://awesheditz.eu.cc/";
$schemaScript = "";

$route = isset($_GET['route']) ? $_GET['route'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($route === 'app-detail' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM apps WHERE id = ?");
    $stmt->execute([$id]);
    $app = $stmt->fetch();
    if ($app) {
        $seoTitle = $app['title'] . " MOD APK " . $app['version'] . " (" . ($app['modFeatures'] ? $app['modFeatures'] : 'Premium Unlocked') . ") Download - AweshEditz";
        $seoDesc = $app['seoDesc'] ? $app['seoDesc'] : "Download " . $app['title'] . " MOD APK " . $app['version'] . " for Android. Unlocked MOD Features: " . ($app['modFeatures'] ? $app['modFeatures'] : 'All Content Unlocked') . ". Safe and fast download links on AweshEditz.";
        $seoKeywords = $app['seoKeywords'] ? $app['seoKeywords'] : $app['title'] . " mod apk, download " . $app['title'] . " hack, android game, awesheditz";
        $seoImage = $app['iconUrl'];
        $canonicalUrl = "https://awesheditz.eu.cc/#app-detail/" . $app['id'];

        // Inject dynamic Software schema structure
        $category = ($app['type'] === 'Game') ? "GameApplication" : "BusinessApplication";
        $rating = $app['rating'] ? $app['rating'] : "4.5";
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "SoftwareApplication",
            "name" => $app['title'],
            "operatingSystem" => "Android",
            "applicationCategory" => $category,
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => $rating,
                "ratingCount" => "180"
            ],
            "offers" => [
                "@type" => "Offer",
                "price" => "0",
                "priceCurrency" => "USD"
            ]
        ];
        $schemaScript = '<script type="application/ld+json" id="dynamic-app-schema">' . json_encode($schema) . '</script>';
    }
} elseif ($route === 'news-detail' && $id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $news = $stmt->fetch();
    if ($news) {
        $seoTitle = $news['title'] . " - AweshEditz News";
        $seoDesc = $news['seoDesc'] ? $news['seoDesc'] : $news['title'] . ". Read the latest details and update logs dynamically on AweshEditz.";
        $seoKeywords = $news['seoKeywords'] ? $news['seoKeywords'] : "news, " . $news['category'] . ", tech updates, awesheditz";
        $seoImage = $news['imageUrl'];
        $canonicalUrl = "https://awesheditz.eu.cc/#news-detail/" . $news['id'];

        // Inject dynamic News schema structure
        $published = isset($news['createdAt']) ? date('c', strtotime($news['createdAt'])) : date('c');
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => $news['title'],
            "image" => [$news['imageUrl']],
            "datePublished" => $published,
            "author" => [
                "@type" => "Organization",
                "name" => "AweshEditz",
                "url" => "https://awesheditz.eu.cc/"
            ]
        ];
        $schemaScript = '<script type="application/ld+json" id="dynamic-article-schema">' . json_encode($schema) . '</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta name="google-site-verification" content="oImP1y_gkIQOI92ooHo-XrOjzTitzrG98fDDF6j8QZ0" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($seoTitle); ?></title>

  <!-- ================= FAVICON ICON ================= -->
  <link class="dyn-favicon" rel="icon" type="image/png" href="https://awesheditz.eu.cc/favicon.png">
  <link class="dyn-favicon" rel="shortcut icon" type="image/x-icon" href="https://awesheditz.eu.cc/favicon.png">

  <!-- ================= MASTER SEO META TAGS ================= -->
  <meta name="description" content="<?php echo htmlspecialchars($seoDesc); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($seoKeywords); ?>">
  <meta name="robots" content="index, follow">
  <link class="canonical" href="<?php echo htmlspecialchars($canonicalUrl); ?>">

  <!-- Open Graph (OG) / Facebook / Telegram Previews -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl); ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($seoTitle); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($seoDesc); ?>">
  <meta property="og:image" content="<?php echo htmlspecialchars($seoImage); ?>">

  <!-- Twitter Previews -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="<?php echo htmlspecialchars($canonicalUrl); ?>">
  <meta property="twitter:title" content="<?php echo htmlspecialchars($seoTitle); ?>">
  <meta property="twitter:description" content="<?php echo htmlspecialchars($seoDesc); ?>">
  <meta property="twitter:image" content="<?php echo htmlspecialchars($seoImage); ?>">

  <!-- JSON-LD Structured Data (Google Sitelinks Search Box) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "AweshEditz",
    "url": "https://awesheditz.eu.cc/",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://awesheditz.eu.cc/#browse?search={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  }
  </script>
  <?php echo $schemaScript; ?>

  <!-- Tailwind CSS & Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: '#7cb342',
            brandDark: '#558b2f',
            cardBg: '#ffffff',
            bodyBg: '#f6f8fa'
          }
        }
      }
    }
  </script>
  <style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
  <!-- Popunder script target injection zone -->
  <div id="ad-popunder"></div>
  <!-- Social Bar ad target injection zone -->
  <div id="ad-socialbar"></div>
</head>
<body class="bg-[#f6f8fa] text-slate-800 font-sans flex flex-col min-h-screen">

  <!-- Dynamic Floating Telegram Button -->
  <div id="telegram-float-container" class="fixed bottom-24 right-6 z-50 hidden">
    <a id="telegram-float-link" href="javascript:void(0)" target="_blank" rel="noopener" class="bg-[#1FB2FF] hover:bg-[#1FB2FF] text-white p-4 rounded-full shadow-2xl flex items-center justify-center space-x-2 transition-transform hover:scale-105">
      <i class="fa-brands fa-telegram text-2xl"></i>
      <span class="text-xs font-bold pr-2 hidden md:inline">Join Channel</span>
    </a>
  </div>

  <!-- Header -->
  <header class="sticky top-0 bg-white border-b border-gray-100 z-50 px-4 py-3 flex items-center justify-between shadow-sm">
    <div class="flex items-center space-x-3">
      <button id="sidebar-toggle" class="text-slate-600 p-2 hover:bg-slate-100 rounded-lg lg:hidden">
        <i class="fa-solid fa-bars text-xl"></i>
      </button>
      <a href="javascript:void(0)" onclick="navigate('home')" class="flex items-center space-x-2">
        <div class="bg-brand text-white p-2 rounded-xl flex items-center justify-center">
          <i class="fa-solid fa-wand-magic-sparkles text-lg"></i>
        </div>
        <span class="text-xl font-bold tracking-tight text-slate-900">Awesh<span class="text-brand">Editz</span></span>
      </a>
    </div>

    <!-- Search bar -->
    <div class="hidden md:flex items-center flex-1 max-w-md mx-8 relative">
      <input id="search-input-lg" type="text" placeholder="Search apps, games, articles..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand focus:border-brand outline-none text-sm bg-slate-50">
      <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-sm"></i>
    </div>

    <div class="flex items-center space-x-2">
      <button onclick="navigate('browse')" class="p-2.5 hover:bg-slate-100 rounded-xl text-slate-600">
        <i class="fa-solid fa-magnifying-glass text-lg"></i>
      </button>
    </div>
  </header>

  <!-- Sidebar Drawer -->
  <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-50 hidden transition-opacity lg:hidden"></div>
  <aside id="sidebar-nav" class="fixed top-0 bottom-0 left-0 w-72 bg-white border-r border-gray-100 z-50 -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-out flex flex-col">
    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center space-x-2">
        <div class="bg-brand text-white p-1.5 rounded-lg"><i class="fa-solid fa-wand-magic-sparkles text-sm"></i></div>
        <span class="text-lg font-bold">AweshEditz</span>
      </div>
      <button id="sidebar-close" class="text-slate-500 hover:bg-slate-100 p-1.5 rounded-lg lg:hidden">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
    </div>
    <nav class="flex-1 p-4 space-y-1.5">
      <a href="javascript:void(0)" onclick="navigate('home')" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
        <i class="fa-solid fa-house text-lg"></i><span>Home</span>
      </a>
      <a href="javascript:void(0)" onclick="navigate('apps')" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
        <i class="fa-solid fa-shapes text-lg"></i><span>Apps</span>
      </a>
      <a href="javascript:void(0)" onclick="navigate('games')" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
        <i class="fa-solid fa-gamepad text-lg"></i><span>Games</span>
      </a>
      <a href="javascript:void(0)" onclick="navigate('news')" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
        <i class="fa-solid fa-newspaper text-lg"></i><span>News</span>
      </a>
      <a href="javascript:void(0)" onclick="navigate('browse')" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
        <i class="fa-solid fa-compass text-lg"></i><span>Browse</span>
      </a>
      <a href="https://awesheditz.eu.cc/AweshEditz%20Apks%20Store.apk" target="_blank" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium">
    <i class="fa-solid fa-download text-lg"></i>
    <span>AweshEditz Apks Store</span>
</a>
    </nav>
  </aside>

  <!-- Main Content Wrapper -->
  <main class="flex-1 lg:pl-72 pb-20 lg:pb-6 transition-all duration-300">
    <!-- Adsterra Header Banner Spot -->
    <div class="ad-slot max-w-5xl mx-auto px-4 py-3" id="ad-header"></div>

    <div class="max-w-5xl mx-auto p-4 lg:p-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- Left Content Area -->
      <div id="content-area" class="lg:col-span-3 space-y-8"></div>
      
      <!-- Right Sidebar Area -->
      <aside class="hidden lg:block lg:col-span-1 space-y-6">
        <div id="ad-sidebar" class="ad-slot rounded-2xl overflow-hidden bg-white border border-slate-100 p-2 shadow-sm min-h-[400px] flex items-center justify-center">
          <span class="text-slate-300 text-xs">Advertisement</span>
        </div>
      </aside>
    </div>

    <!-- Adsterra Footer Banner Spot -->
    <div class="ad-slot max-w-5xl mx-auto px-4 py-3 mt-auto" id="ad-footer"></div>
  </main>

  <!-- Mobile Bottom Nav -->
  <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-50 flex items-center justify-around py-2.5 px-1 shadow-2xl lg:hidden">
    <button onclick="navigate('home')" class="mob-nav flex flex-col items-center justify-center text-slate-400 flex-1">
      <i class="fa-solid fa-house text-lg mb-1"></i>
      <span class="text-[10px] font-medium">Home</span>
    </button>
    <button onclick="navigate('apps')" class="mob-nav flex flex-col items-center justify-center text-slate-400 flex-1">
      <i class="fa-solid fa-shapes text-lg mb-1"></i>
      <span class="text-[10px] font-medium">Apps</span>
    </button>
    <button onclick="navigate('games')" class="mob-nav flex flex-col items-center justify-center text-slate-400 flex-1">
      <i class="fa-solid fa-gamepad text-lg mb-1"></i>
      <span class="text-[10px] font-medium">Games</span>
    </button>
    <button onclick="navigate('news')" class="mob-nav flex flex-col items-center justify-center text-slate-400 flex-1">
      <i class="fa-solid fa-newspaper text-lg mb-1"></i>
      <span class="text-[10px] font-medium">News</span>
    </button>
    <button onclick="navigate('browse')" class="mob-nav flex flex-col items-center justify-center text-slate-400 flex-1">
      <i class="fa-solid fa-compass text-lg mb-1"></i>
      <span class="text-[10px] font-medium">Browse</span>
    </button>
  </nav>

  <!-- Script Modules -->
  <script type="text/javascript">
    let appsData = [];
    let newsData = [];
    let siteSettings = { 
      maintenance: false, 
      adsterraHeader: "", 
      adsterraFooter: "", 
      adsterraDetail: "",
      adsterraSidebar: "",
      adsterraNative: "",
      adsterraSocialBar: "",
      adsterraPopunder: "",
      telegramLink: ""
    };
    
    let currentRoute = null;
    let currentParam = null;
    let scrollPositions = {};

    const contentArea = document.getElementById('content-area');
    const sidebar = document.getElementById('sidebar-nav');
    const overlay = document.getElementById('sidebar-overlay');

    function formatDate(timestamp, longFormat = true) {
      if (!timestamp) return longFormat ? 'May 27, 2026' : '05/27/2026';
      
      let dateObj = new Date(timestamp);
      if (isNaN(dateObj.getTime())) return longFormat ? 'May 27, 2026' : '05/27/2026';

      if (longFormat) {
        return dateObj.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
      }
      return dateObj.toLocaleDateString();
    }

    function updateDynamicSEO(title, description, keywords, canonicalUrl, image) {
      document.title = title;
      
      const setMeta = (selector, attr, val) => {
        const el = document.querySelector(selector);
        if (el) el.setAttribute(attr, val);
      };

      setMeta('meta[name="description"]', 'content', description);
      setMeta('meta[name="keywords"]', 'content', keywords);
      
      setMeta('meta[property="og:title"]', 'content', title);
      setMeta('meta[property="og:description"]', 'content', description);
      setMeta('meta[property="og:url"]', 'content', canonicalUrl);
      if (image) setMeta('meta[property="og:image"]', 'content', image);
      
      setMeta('meta[property="twitter:title"]', 'content', title);
      setMeta('meta[property="twitter:description"]', 'content', description);
      setMeta('meta[property="twitter:url"]', 'content', canonicalUrl);
      if (image) setMeta('meta[property="twitter:image"]', 'content', image);
      
      setMeta('link[rel="canonical"]', 'href', canonicalUrl);
    }

    function injectGoogleSoftwareSchema(app) {
      const oldSchema = document.getElementById('dynamic-app-schema');
      if (oldSchema) oldSchema.remove();

      const schema = {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": app.title,
        "operatingSystem": "Android",
        "applicationCategory": app.type === 'Game' ? "GameApplication" : "BusinessApplication",
        "aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": app.rating || "4.5",
          "ratingCount": "180"
        },
        "offers": {
          "@type": "Offer",
          "price": "0",
          "priceCurrency": "USD"
        }
      };

      const script = document.createElement('script');
      script.id = 'dynamic-app-schema';
      script.type = 'application/ld+json';
      script.text = JSON.stringify(schema);
      document.head.appendChild(script);
    }

    function injectGoogleArticleSchema(article) {
      const oldSchema = document.getElementById('dynamic-article-schema');
      if (oldSchema) oldSchema.remove();

      const schema = {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": article.title,
        "image": [ article.imageUrl ],
        "datePublished": article.createdAt ? new Date(article.createdAt).toISOString() : new Date().toISOString(),
        "author": {
          "@type": "Organization",
          "name": "AweshEditz",
          "url": "https://awesheditz.eu.cc/"
        }
      };

      const script = document.createElement('script');
      script.id = 'dynamic-article-schema';
      script.type = 'application/ld+json';
      script.text = JSON.stringify(schema);
      document.head.appendChild(script);
    }

    async function recordUniqueVisit() {
      const today = new Date().toISOString().slice(0, 10);
      const lastVisit = localStorage.getItem('awesh_last_visit');
      
      if (lastVisit !== today) {
        try {
          await fetch('api.php?action=logVisit');
          localStorage.setItem('awesh_last_visit', today);
        } catch (e) {
          console.error("Visit log failed: ", e);
        }
      }
    }

    window.recordUniqueDownload = async (appId) => {
      let downloadedApps = [];
      try {
        const stored = localStorage.getItem('awesh_downloaded_apps');
        if (stored) {
          downloadedApps = JSON.parse(stored);
        }
      } catch (e) {
        console.error(e);
      }

      if (!downloadedApps.includes(appId)) {
        try {
          const res = await fetch('api.php?action=logDownload&appId=' + appId);
          const data = await res.json();
          if (data.status === 'success') {
            downloadedApps.push(appId);
            localStorage.setItem('awesh_downloaded_apps', JSON.stringify(downloadedApps));
          }
        } catch (err) {
          console.error("Download log failed: ", err);
        }
      }
    };

    // Array shuffle utility function (Fisher-Yates) for random layout
    function shuffleArray(array) {
      let shuffled = [...array];
      for (let i = shuffled.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        const temp = shuffled[i];
        shuffled[i] = shuffled[j];
        shuffled[j] = temp;
      }
      return shuffled;
    }

    // Sidebar controls
    document.getElementById('sidebar-toggle').addEventListener('click', () => {
      sidebar.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
    });
    const closeSidebar = () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    };
    document.getElementById('sidebar-close').addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    window.navigate = async (route, param = null, updateHistory = true) => {
      if (currentRoute) {
        scrollPositions[currentRoute + (currentParam ? '_' + currentParam : '')] = window.scrollY;
      }

      closeSidebar();
      updateNavigationHighlight(route);

      currentRoute = route;
      currentParam = param;

      if (updateHistory) {
        const hash = `#${route}` + (param ? `/${param}` : '');
        history.pushState({ route, param }, "", hash);
      }

      if (route === 'home') {
        renderHome();
      } else if (route === 'apps') {
        renderCategoryPage('App');
      } else if (route === 'games') {
        renderCategoryPage('Game');
      } else if (route === 'news') {
        renderNewsPage();
      } else if (route === 'browse') {
        renderBrowsePage();
      } else if (route === 'app-detail' && param) {
        await renderAppDetail(param);
      } else if (route === 'news-detail' && param) {
        await renderNewsDetail(param);
      }

      const savedKey = route + (param ? '_' + param : '');
      requestAnimationFrame(() => {
        setTimeout(() => {
          if (scrollPositions[savedKey] !== undefined) {
            window.scrollTo({ top: scrollPositions[savedKey], behavior: 'auto' });
          } else {
            window.scrollTo({ top: 0, behavior: 'auto' });
          }
        }, 50);
      });
    };

    window.addEventListener('popstate', (event) => {
      if (event.state && event.state.route) {
        navigate(event.state.route, event.state.param, false);
      } else {
        const currentHash = window.location.hash;
        if (currentHash) {
          const parts = currentHash.replace('#', '').split('/');
          const route = parts[0];
          const param = parts[1] || null;
          if (route === currentRoute && param === currentParam) {
            return;
          }
          navigate(route, param, false);
        } else {
          navigate('home', null, false);
        }
      }
    });

    function updateNavigationHighlight(route) {
      const targetMap = { home: 0, apps: 1, games: 2, news: 3, browse: 4 };
      const index = targetMap[route];

      document.querySelectorAll('.nav-item').forEach((el, idx) => {
        if (index !== undefined && idx === index) {
          el.className = "nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-brand font-semibold bg-brand/5";
        } else {
          el.className = "nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 font-medium";
        }
      });

      document.querySelectorAll('.mob-nav').forEach((el, idx) => {
        if (index !== undefined && idx === index) {
          el.className = "mob-nav flex flex-col items-center justify-center text-brand font-bold flex-1";
        } else {
          el.className = "mob-nav flex flex-col items-center justify-center text-slate-400 flex-1";
        }
      });
    }

    async function init() {
      try {
        const response = await fetch('api.php?action=getInitData');
        const rData = await response.json();
        
        if (rData.status === 'success') {
          siteSettings = rData.settings;
          appsData = rData.apps;
          newsData = rData.news;

          if (siteSettings.maintenance) {
            document.body.innerHTML = `
              <div class="flex flex-col items-center justify-center min-h-screen p-6 bg-slate-50">
                <div class="text-center space-y-4 max-w-md">
                  <div class="text-brand text-6xl"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                  <h1 class="text-3xl font-black text-slate-900">Maintenance Mode</h1>
                  <p class="text-slate-500 text-sm">We are updating our catalog. Please check back later.</p>
                </div>
              </div>
            `;
            return;
          }

          injectAdsterraAds();
          injectTelegramConfig();
        }

        await recordUniqueVisit();

        const currentHash = window.location.hash;
        if (currentHash) {
          const parts = currentHash.replace('#', '').split('/');
          const initialRoute = parts[0];
          const initialParam = parts[1] || null;
          history.replaceState({ route: initialRoute, param: initialParam }, "", currentHash);
          await navigate(initialRoute, initialParam, false);
        } else {
          // If server parsed direct routing queries initially (For clean SEO indexation)
          const parsedRoute = "<?php echo $route; ?>";
          const parsedId = "<?php echo $id; ?>";
          if (parsedRoute && parsedId) {
             history.replaceState({ route: parsedRoute, param: parsedId }, "", "#" + parsedRoute + "/" + parsedId);
             await navigate(parsedRoute, parsedId, false);
          } else {
             history.replaceState({ route: 'home', param: null }, "", "#home");
             await navigate('home', null, false);
          }
        }

      } catch (err) {
        console.error("Initialization Failed: ", err);
        contentArea.innerHTML = `<div class="p-8 text-center text-slate-500">Error connecting to database. Please refresh later.</div>`;
      }
    }

    function injectAdsterraAds() {
      if (siteSettings.adsterraHeader) {
        executeAdScript('ad-header', siteSettings.adsterraHeader);
      }
      if (siteSettings.adsterraFooter) {
        executeAdScript('ad-footer', siteSettings.adsterraFooter);
      }
      if (siteSettings.adsterraSidebar) {
        executeAdScript('ad-sidebar', siteSettings.adsterraSidebar);
      }
      if (siteSettings.adsterraPopunder) {
        executeAdScript('ad-popunder', siteSettings.adsterraPopunder);
      }
      if (siteSettings.adsterraSocialBar) {
        executeAdScript('ad-socialbar', siteSettings.adsterraSocialBar);
      }
    }

    function injectTelegramConfig() {
      if (siteSettings.telegramLink && siteSettings.telegramLink.trim() !== "") {
        const tgBtn = document.getElementById('telegram-float-container');
        const tgLink = document.getElementById('telegram-float-link');
        tgLink.href = siteSettings.telegramLink;
        tgBtn.classList.remove('hidden');
      }
    }

    function executeAdScript(elementId, scriptString) {
      const container = document.getElementById(elementId);
      if (!container) return;
      container.innerHTML = "";
      const range = document.createRange();
      range.selectNode(container);
      const documentFragment = range.createContextualFragment(scriptString);
      container.appendChild(documentFragment);
    }

    function renderHome() {
      updateDynamicSEO(
        "AweshEditz - Download MOD APK Games & Apps",
        "AweshEditz is the ultimate hub to download 100% working MOD APK games, premium unlocked Android apps, and premium configurations free.",
        "awesheditz, awesh editz, mod apk, awesh edits, Capcut, capcut pro, premium apk, download hack games, android mod games",
        "https://awesheditz.eu.cc/",
        "https://awesheditz.eu.cc/icon.png"
      );

      // Explicitly sort data to place recently created or recently updated items at the top
      const sortedForHome = [...appsData].sort((a, b) => {
        const dateA = new Date(a.updatedAt ? a.updatedAt : a.createdAt).getTime();
        const dateB = new Date(b.updatedAt ? b.updatedAt : b.createdAt).getTime();
        return dateB - dateA;
      });

      const latestGames = sortedForHome.filter(item => item.type === 'Game').slice(0, 8);
      const latestApps = sortedForHome.filter(item => item.type === 'App').slice(0, 8);
      const trending = sortedForHome.slice(0, 3);

      let nativeAdZone = siteSettings.adsterraNative ? `<div class="p-4 bg-white rounded-2xl border border-slate-100 my-4 shadow-sm" id="ad-native-home"></div>` : '';

      let html = `
        <div class="space-y-4">
          <h2 class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center space-x-2">
            <i class="fa-solid fa-fire text-amber-500"></i><span>Indispensable on your phone</span>
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            ${trending.map(item => `
              <div onclick="navigate('app-detail', '${item.id}')" class="relative group cursor-pointer bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl overflow-hidden h-44 shadow-lg flex flex-col justify-end p-5 text-white">
                <img src="${item.iconUrl}" alt="${item.title}" class="absolute top-5 right-5 w-16 h-16 rounded-2xl border border-white/10 group-hover:scale-105 transition-transform">
                <div class="z-10 max-w-[70%]">
                  <span class="bg-brand text-xs px-2.5 py-1 rounded-full font-bold mb-2 inline-block">Editor's Choice</span>
                  <h3 class="font-bold text-lg leading-tight truncate">${item.title}</h3>
                  <p class="text-white/70 text-xs mt-1 truncate">${item.category}</p>
                </div>
                <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
              </div>
            `).join('')}
          </div>
        </div>

        ${nativeAdZone}

        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center space-x-2">
              <i class="fa-solid fa-gamepad text-brand"></i><span>Latest Games</span>
            </h2>
            <button onclick="navigate('games')" class="text-brand font-bold text-sm hover:underline">More <i class="fa-solid fa-arrow-right ml-1"></i></button>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            ${latestGames.map(game => getAppCardTemplate(game, false)).join('')}
          </div>
        </div>

        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center space-x-2">
              <i class="fa-solid fa-shapes text-brand"></i><span>Latest Apps</span>
            </h2>
            <button onclick="navigate('apps')" class="text-brand font-bold text-sm hover:underline">More <i class="fa-solid fa-arrow-right ml-1"></i></button>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            ${latestApps.map(app => getAppCardTemplate(app, false)).join('')}
          </div>
        </div>
      `;
      contentArea.innerHTML = html;

      if (siteSettings.adsterraNative) {
        executeAdScript('ad-native-home', siteSettings.adsterraNative);
      }
    }

    function getAppCardTemplate(item, isGrid = false) {
      const isPaid = item.badges?.includes('Paid');
      const isPremium = item.badges?.includes('Premium');
      const rateStr = item.rating ? Number(item.rating).toFixed(1) : "4.2";
      const displayId = item.id;
      
      if (isGrid) {
        return `
          <div onclick="navigate('app-detail', '${displayId}')" class="bg-white border border-gray-100 rounded-2xl p-3 flex flex-col items-center justify-between text-center cursor-pointer hover:shadow-md transition-all relative h-full">
            <div class="absolute top-2 right-2 flex flex-col gap-1 z-10">
              ${isPaid ? `
                <span class="bg-red-500 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-md">PAID</span>
              ` : isPremium ? `
                <span class="bg-brand text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-md">PREMIUM</span>
              ` : ''}
            </div>

            <div class="flex flex-col items-center w-full">
              <img src="${item.iconUrl}" alt="${item.title}" class="w-14 h-14 md:w-16 md:h-16 rounded-2xl object-cover border border-slate-100 shadow-sm mb-2">
              <h3 class="font-bold text-slate-800 text-xs md:text-sm line-clamp-1 w-full px-0.5">${item.title}</h3>
              
              <div class="flex items-center justify-center space-x-1.5 mt-1 text-[10px] text-slate-400 w-full">
                <span class="text-amber-500 font-bold flex items-center">
                  <i class="fa-solid fa-star text-[9px] mr-0.5"></i>${rateStr}
                </span>
                <span>•</span>
                <span class="truncate max-w-[65px]">${item.category}</span>
              </div>
            </div>

            <div class="w-full mt-2 pt-2 border-t border-slate-50 flex-shrink-0">
              <p class="text-brand font-semibold text-[10px] truncate flex items-center justify-center space-x-1 bg-brand/5 py-1 px-1.5 rounded-lg w-full">
                <span class="bg-brand/10 text-brand px-1 py-0.5 rounded text-[8px] uppercase font-black">MOD</span>
                <span class="truncate">${item.modFeatures || 'Unlocked'}</span>
              </p>
            </div>
          </div>
        `;
      }

      return `
        <div onclick="navigate('app-detail', '${displayId}')" class="bg-white border border-gray-100 rounded-2xl p-4 flex items-center space-x-4 cursor-pointer hover:shadow-md transition-shadow relative">
          <img src="${item.iconUrl}" alt="${item.title}" class="w-16 h-16 rounded-2xl object-cover border border-slate-100 flex-shrink-0">
          <div class="flex-1 min-w-0">
            <h3 class="font-bold text-slate-800 text-base truncate pr-14 leading-snug">${item.title}</h3>
            <div class="flex items-center space-x-2 mt-1">
              <span class="text-amber-500 font-bold text-xs flex items-center">
                <i class="fa-solid fa-star text-[10px] mr-1"></i>${rateStr}
              </span>
              <span class="text-slate-300 text-xs">•</span>
              <span class="text-slate-400 text-xs truncate">${item.category}</span>
            </div>
            <p class="text-brand font-semibold text-xs mt-1.5 truncate flex items-center space-x-1">
              <span class="bg-brand/10 text-brand px-1.5 py-0.5 rounded text-[10px] uppercase font-bold">MOD</span>
              <span class="truncate">${item.modFeatures || 'Unlocked All Content'}</span>
            </p>
          </div>
          ${isPaid ? `
            <span class="absolute top-4 right-4 bg-red-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full">PAID</span>
          ` : isPremium ? `
            <span class="absolute top-4 right-4 bg-brand text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full">PREMIUM</span>
          ` : ''}
        </div>
      `;
    }

    window.startDownloadTimer = (boxId, downloadUrl, label, appId) => {
      const container = document.getElementById(boxId);
      if (!container) return;
      let countdown = 15;

      container.innerHTML = `
        <button disabled class="w-full md:w-auto px-8 py-4 bg-slate-400 text-white text-center font-black rounded-2xl flex items-center justify-center space-x-3 cursor-not-allowed">
          <i class="fa-solid fa-spinner animate-spin"></i>
          <span>Generating ${label}... <span id="${boxId}-counter" class="text-yellow-200">${countdown}</span>s</span>
        </button>
      `;

      const interval = setInterval(() => {
        countdown--;
        const span = document.getElementById(`${boxId}-counter`);
        if (span) span.innerText = countdown;

        if (countdown <= 0) {
          clearInterval(interval);
          container.innerHTML = `
            <a href="${downloadUrl}" onclick="recordUniqueDownload('${appId}')" target="_blank" rel="noopener" class="w-full md:w-auto px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-center font-black rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center space-x-2 animate-bounce">
              <i class="fa-solid fa-circle-down text-lg"></i>
              <span>Download Ready (${label})</span>
            </a>
          `;
        }
      }, 1000);
    };

    function renderCategoryPage(type) {
      const filtered = appsData.filter(item => item.type === type);
      
      // Shuffle the list to show products randomly every time the tab is loaded
      const randomized = shuffleArray(filtered);

      const title = type === 'App' ? 'Premium Applications' : 'Unlocked MOD Games';
      const icon = type === 'App' ? 'fa-shapes' : 'fa-gamepad';

      let html = `
        <div class="space-y-6">
          <div class="border-b border-gray-100 pb-4">
            <h1 class="text-2xl font-black text-slate-900 flex items-center space-x-3">
              <i class="fa-solid ${icon} text-brand"></i>
              <span>${title}</span>
            </h1>
          </div>
          <div class="grid grid-cols-2 gap-3 md:gap-4">
            ${randomized.length ? randomized.map(item => getAppCardTemplate(item, true)).join('') : '<p class="text-slate-400 p-8 col-span-2">No content uploaded yet.</p>'}
          </div>
        </div>
      `;
      contentArea.innerHTML = html;
    }

    function renderBrowsePage() {
      let html = `
        <div class="space-y-6">
          <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h1 class="text-xl font-extrabold text-slate-900">Advanced App Engine</h1>
            <p class="text-slate-500 text-xs">Filter and discover high-quality modded apps dynamically.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
              <input id="filter-search" type="text" placeholder="Search title..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-brand text-sm bg-slate-50">
              
              <select id="filter-genre" class="px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-brand text-sm bg-slate-50">
                <option value="">All Categories/Genres</option>
                ${[...new Set(appsData.map(a => a.category))].map(cat => `<option value="${cat}">${cat}</option>`).join('')}
              </select>

              <select id="filter-type" class="px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-brand text-sm bg-slate-50">
                <option value="">All Content Types</option>
                <option value="App">Apps Only</option>
                <option value="Game">Games Only</option>
              </select>
            </div>
            <button id="apply-filter-btn" class="w-full py-3 bg-brand hover:bg-brandDark text-white font-bold rounded-xl transition-colors">Apply Filters</button>
          </div>

          <div id="browse-results-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            ${appsData.map(item => getAppCardTemplate(item, false)).join('')}
          </div>
        </div>
      `;

      contentArea.innerHTML = html;

      document.getElementById('apply-filter-btn').addEventListener('click', () => {
        const queryVal = document.getElementById('filter-search').value.toLowerCase().trim();
        const genreVal = document.getElementById('filter-genre').value;
        const typeVal = document.getElementById('filter-type').value;

        let results = appsData.filter(item => {
          const matchQuery = !queryVal || item.title.toLowerCase().includes(queryVal);
          const matchGenre = !genreVal || item.category === genreVal;
          const matchType = !typeVal || item.type === typeVal;
          return matchQuery && matchGenre && matchType;
        });

        const targetGrid = document.getElementById('browse-results-grid');
        if (results.length) {
          targetGrid.innerHTML = results.map(item => getAppCardTemplate(item, false)).join('');
        } else {
          targetGrid.innerHTML = `<div class="col-span-full py-12 text-center text-slate-400">No matches found for selections.</div>`;
        }
      });
    }

    async function renderAppDetail(id) {
      const app = appsData.find(item => String(item.id) === String(id));
      if (!app) return;

      const pageTitle = `${app.title} MOD APK ${app.version} (${app.modFeatures || 'Premium Unlocked'}) Download - AweshEditz`;
      const pageDesc = app.seoDesc || `Download ${app.title} MOD APK ${app.version} for Android. Unlocked MOD Features: ${app.modFeatures || 'All Content Unlocked'}. Safe and fast download links on AweshEditz.`;
      const pageKeywords = app.seoKeywords || `${app.title} mod apk, download ${app.title} hack, android game, awesheditz`;
      const canonical = `https://awesheditz.eu.cc/#app-detail/${app.id}`;
      
      updateDynamicSEO(pageTitle, pageDesc, pageKeywords, canonical, app.iconUrl);
      injectGoogleSoftwareSchema(app);

      const sizeStr = app.size ? app.size : "45M";
      const verStr = app.version ? app.version : "1.0.0";
      const rateStr = app.rating ? Number(app.rating).toFixed(1) : "4.5";

      const publishDate = formatDate(app.createdAt, true);
      const updateDate = formatDate(app.updatedAt || app.createdAt, true);

      const customDetailAdHtml = siteSettings.adsterraDetail ? `<div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100 my-4" id="ad-detail-spot"></div>` : '';

      let screenshotsHtml = '';
      if (app.screenshots) {
        const list = Array.isArray(app.screenshots) ? app.screenshots : app.screenshots.split(',');
        screenshotsHtml = list.map(src => `<img src="${src.trim()}" alt="Screenshot" class="h-80 rounded-xl border border-slate-100 shadow-sm flex-shrink-0">`).join('');
      }

      let telegramBanner = '';
      if (siteSettings.telegramLink && siteSettings.telegramLink.trim() !== '') {
        telegramBanner = `
          <div class="bg-sky-50 border border-sky-100 rounded-2xl p-5 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
              <i class="fa-brands fa-telegram text-sky-500 text-4xl"></i>
              <div>
                <h3 class="font-extrabold text-sky-950">Join our WhatsApp Channel</h3>
                <p class="text-sky-700 text-xs">Get instant notifications for new updates and mod configurations!</p>
              </div>
            </div>
            <a href="${siteSettings.telegramLink}" target="_blank" rel="noopener" class="bg-[#1FB2FF] hover:bg-[#1FB2FF] text-white px-5 py-2 rounded-xl text-sm font-bold flex items-center space-x-1">
              <span>Subscribe</span><i class="fa-solid fa-angle-right"></i>
            </a>
          </div>
        `;
      }

      const primaryBtnLabel = app.downloadTitle || "Main App Link";
      const secondaryBtnLabel = app.downloadTitle2 || "Secondary File Link";

      let downloadSectionHtml = `
        <div class="flex flex-col gap-3 w-full md:w-auto">
          <div id="download-action-box-1" class="w-full md:w-auto">
            <button onclick="startDownloadTimer('download-action-box-1', '${app.downloadUrl}', '${primaryBtnLabel}', '${app.id}')" class="w-full md:w-auto px-8 py-4 bg-brand hover:bg-brandDark text-white text-center font-black rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center space-x-2">
              <i class="fa-solid fa-cloud-arrow-down text-lg"></i><span>${primaryBtnLabel}</span>
            </button>
          </div>
      `;

      if (app.downloadUrl2 && app.downloadUrl2.trim() !== '') {
        downloadSectionHtml += `
          <div id="download-action-box-2" class="w-full md:w-auto">
            <button onclick="startDownloadTimer('download-action-box-2', '${app.downloadUrl2}', '${secondaryBtnLabel}', '${app.id}')" class="w-full md:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white text-center font-black rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center space-x-2">
              <i class="fa-solid fa-cloud-arrow-down text-lg"></i><span>${secondaryBtnLabel}</span>
            </button>
          </div>
        `;
      }

      downloadSectionHtml += `</div>`;

      let html = `
        <div class="space-y-6">
          <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center space-x-5">
              <img src="${app.iconUrl}" alt="${app.title}" class="w-24 h-24 rounded-3xl object-cover border border-slate-100 shadow-sm">
              <div>
                <h1 class="text-2xl font-black text-slate-900 leading-tight">${app.title}</h1>
                <div class="flex flex-wrap gap-2 mt-2">
                  <span class="bg-brand/10 text-brand text-xs font-extrabold px-2.5 py-1 rounded-full uppercase">${app.type}</span>
                  <span class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-full">${app.category}</span>
                </div>
              </div>
            </div>
            
            ${downloadSectionHtml}
          </div>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-2xl text-center border border-slate-100 shadow-sm">
              <i class="fa-solid fa-star text-amber-500 mb-1 text-lg"></i>
              <p class="text-slate-400 text-xs font-semibold">Rating</p>
              <h4 class="font-extrabold text-slate-800 text-base mt-0.5">${rateStr} / 5</h4>
            </div>
            <div class="bg-white p-4 rounded-2xl text-center border border-slate-100 shadow-sm">
              <i class="fa-solid fa-server text-brand mb-1 text-lg"></i>
              <p class="text-slate-400 text-xs font-semibold">File Size</p>
              <h4 class="font-extrabold text-slate-800 text-base mt-0.5">${sizeStr}</h4>
            </div>
            <div class="bg-white p-4 rounded-2xl text-center border border-slate-100 shadow-sm">
              <i class="fa-solid fa-code-branch text-indigo-500 mb-1 text-lg"></i>
              <p class="text-slate-400 text-xs font-semibold">Version</p>
              <h4 class="font-extrabold text-slate-800 text-base mt-0.5">${verStr}</h4>
            </div>
            <div class="bg-white p-4 rounded-2xl text-center border border-slate-100 shadow-sm">
              <i class="fa-solid fa-circle-info text-rose-500 mb-1 text-lg"></i>
              <p class="text-slate-400 text-xs font-semibold">Status</p>
              <h4 class="font-extrabold text-brand text-base mt-0.5">Active / MOD</h4>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white px-5 py-3.5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between text-xs">
              <span class="text-slate-400 font-semibold"><i class="fa-solid fa-calendar-plus mr-1.5 text-brand"></i>Published Date</span>
              <span class="font-bold text-slate-800">${publishDate}</span>
            </div>
            <div class="bg-white px-5 py-3.5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between text-xs">
              <span class="text-slate-400 font-semibold"><i class="fa-solid fa-arrows-rotate mr-1.5 text-indigo-500"></i>Last Updated</span>
              <span class="font-bold text-slate-800">${updateDate}</span>
            </div>
          </div>

          <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-5 flex items-start space-x-3">
            <i class="fa-solid fa-shield-halved text-emerald-600 text-xl mt-0.5"></i>
            <div>
              <h3 class="font-extrabold text-emerald-900">MOD Capabilities</h3>
              <p class="text-emerald-700 text-sm mt-1">${app.modFeatures || 'Ad-Free, Unlocked Content, VIP Access Activated.'}</p>
            </div>
          </div>

          ${telegramBanner}
          ${customDetailAdHtml}

          ${screenshotsHtml ? `
            <div class="space-y-3">
              <h3 class="text-lg font-black text-slate-800">Screenshots</h3>
              <div class="flex space-x-4 overflow-x-auto no-scrollbar pb-2">
                ${screenshotsHtml}
              </div>
            </div>
          ` : ''}

          <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-4">
            <h3 class="text-lg font-black text-slate-800 pb-2 border-b border-slate-100">Descriptions</h3>
            <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-wrap">${app.description || 'No detailed review is available for this update.'}</div>
          </div>

          <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm space-y-6">
            <h3 class="text-lg font-black text-slate-800 pb-2 border-b border-slate-100">Live User Reviews</h3>
            
            <div class="space-y-4" id="comments-box">
              <p class="text-slate-400 text-sm">Be the first to leave feedback under this release!</p>
            </div>

            <form id="comment-form" class="space-y-3 mt-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <input required id="comment-author" type="text" placeholder="Full Name" class="w-full px-4 py-2 border border-slate-200 rounded-xl outline-none text-sm bg-slate-50">
                <input required id="comment-email" type="email" placeholder="Email Address" class="w-full px-4 py-2 border border-slate-200 rounded-xl outline-none text-sm bg-slate-50">
              </div>
              <textarea required id="comment-text" placeholder="Write your review here..." rows="3" class="w-full p-4 border border-slate-200 rounded-xl outline-none text-sm bg-slate-50"></textarea>
              <button type="submit" class="px-6 py-2.5 bg-brand hover:bg-brandDark text-white font-bold rounded-xl text-sm transition-colors">Post Review</button>
            </form>
          </div>
        </div>
      `;

      contentArea.innerHTML = html;

      if (siteSettings.adsterraDetail) {
        executeAdScript('ad-detail-spot', siteSettings.adsterraDetail);
      }

      const loadComments = async () => {
        try {
          const res = await fetch('api.php?action=getComments&appId=' + app.id);
          const responseData = await res.json();
          const comBox = document.getElementById('comments-box');
          
          if (responseData.status === 'success' && responseData.comments.length > 0) {
            comBox.innerHTML = responseData.comments.map(item => {
              const date = formatDate(item.createdAt, false);
              return `
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                  <div class="flex items-center justify-between">
                    <h5 class="font-extrabold text-slate-800 text-sm">${item.author}</h5>
                    <span class="text-slate-400 text-[10px]">${date}</span>
                  </div>
                  <p class="text-slate-600 text-xs">${item.text}</p>
                </div>
              `;
            }).join('');
          }
        } catch (error) {
          console.error(error);
        }
      };

      loadComments();

      document.getElementById('comment-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const author = document.getElementById('comment-author').value;
        const email = document.getElementById('comment-email').value;
        const text = document.getElementById('comment-text').value;

        try {
          const res = await fetch('api.php?action=addComment', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ appId: app.id, author, email, text })
          });
          const responseData = await res.json();
          if (responseData.status === 'success') {
            document.getElementById('comment-form').reset();
            loadComments();
          } else {
            alert("Error sending comment: " + responseData.message);
          }
        } catch (err) {
          alert("Error sending comment: " + err.message);
        }
      });
    }

    function renderNewsPage() {
      let html = `
        <div class="space-y-6">
          <div class="border-b border-gray-100 pb-4">
            <h1 class="text-2xl font-black text-slate-900 flex items-center space-x-3">
              <i class="fa-solid fa-newspaper text-brand"></i>
              <span>Articles & Tech Updates</span>
            </h1>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            ${newsData.length ? newsData.map(item => {
              const dateStr = formatDate(item.createdAt, false);
              return `
                <div onclick="navigate('news-detail', '${item.id}')" class="bg-white border border-slate-100 rounded-3xl overflow-hidden cursor-pointer hover:shadow-md transition-shadow flex flex-col h-full">
                  <img src="${item.imageUrl}" alt="${item.title}" class="h-48 w-full object-cover">
                  <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                    <div class="space-y-1.5">
                      <span class="bg-indigo-50 text-indigo-600 text-[10px] font-extrabold px-2 py-0.5 rounded-full uppercase">${item.category || 'Tech'}</span>
                      <h3 class="font-extrabold text-slate-800 text-lg leading-snug line-clamp-2">${item.title}</h3>
                    </div>
                    <div class="flex items-center justify-between text-slate-400 text-[11px] pt-3 border-t border-slate-50">
                      <span><i class="fa-solid fa-calendar-days mr-1"></i>${dateStr}</span>
                      <span><i class="fa-solid fa-clock mr-1"></i>${item.readTime || '3 min'} read</span>
                    </div>
                  </div>
                </div>
              `;
            }).join('') : '<p class="text-slate-400 p-8">No news published yet.</p>'}
          </div>
        </div>
      `;
      contentArea.innerHTML = html;
    }

    function renderNewsDetail(id) {
      const article = newsData.find(item => String(item.id) === String(id));
      if (!article) return;

      const pageTitle = `${article.title} - AweshEditz News`;
      const pageDesc = article.seoDesc || `${article.title}. Read the latest details and update logs dynamically on AweshEditz.`;
      const pageKeywords = article.seoKeywords || `news, ${article.category}, tech updates, awesheditz`;
      const canonical = `https://awesheditz.eu.cc/#news-detail/${article.id}`;

      updateDynamicSEO(pageTitle, pageDesc, pageKeywords, canonical, article.imageUrl);
      injectGoogleArticleSchema(article);

      const dateStr = formatDate(article.createdAt, true);

      let html = `
        <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm max-w-3xl mx-auto">
          <img src="${article.imageUrl}" alt="${article.title}" class="w-full h-80 object-cover">
          <div class="p-6 md:p-8 space-y-4">
            <span class="bg-indigo-50 text-indigo-600 text-xs font-extrabold px-3 py-1 rounded-full uppercase inline-block">${article.category || 'General'}</span>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 leading-tight">${article.title}</h1>
            
            <div class="flex items-center space-x-6 text-slate-400 text-xs border-b border-slate-100 pb-4">
              <span><i class="fa-solid fa-calendar-days mr-1.5"></i>Published on: ${dateStr}</span>
              <span><i class="fa-solid fa-clock mr-1.5"></i>${article.readTime || '3'} mins read</span>
            </div>

            <div class="text-slate-600 text-sm md:text-base leading-relaxed whitespace-pre-wrap pt-2">${article.content}</div>
          </div>
        </div>
      `;
      contentArea.innerHTML = html;
    }

    init();
  </script>
</body>
</html>