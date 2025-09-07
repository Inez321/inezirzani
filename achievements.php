<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Achievements</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: #1e293b;
            padding: 20px;
            min-height: 100vh;
        }
        
        .achievements-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .heading {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .heading h2 {
            font-size: 2.5rem;
            color: #0c4a6e;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .heading span {
            font-size: 1.2rem;
            color: #64748b;
            font-weight: 500;
        }
        
        .achievements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .achievement-box {
            background: linear-gradient(145deg, #ffffff, #f1f5f9);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        
        .achievement-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.15);
        }
        
        .achievement-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, #0ea5e9, #3b82f6);
        }
        
        .achievement-title {
            font-size: 1.5rem;
            color: #0c4a6e;
            margin-bottom: 15px;
            font-weight: 600;
            line-height: 1.4;
        }
        
        .achievement-event {
            font-size: 1.1rem;
            color: #475569;
            margin-bottom: 20px;
            line-height: 1.5;
            font-weight: 500;
        }
        
        .achievement-year {
            display: inline-block;
            background: linear-gradient(to right, #0ea5e9, #3b82f6);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        }
        
        .medal-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #f59e0b;
        }
        
        @media (max-width: 768px) {
            .achievements-grid {
                grid-template-columns: 1fr;
            }
            
            .achievement-box {
                padding: 20px;
            }
            
            .achievement-title {
                font-size: 1.3rem;
            }
            
            .achievement-event {
                font-size: 1rem;
            }
        }
        
        .section-description {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 50px;
            font-size: 1.1rem;
            color: #64748b;
            line-height: 1.6;
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <section class="achievements" id="achievements">
    <div class="achievements-container">
        <div class="heading">
            <h2>Achievements</h2>
            <span>My Awards & Recognitions</span>
        </div>
        
        <p class="section-description">
            Berikut adalah prestasi dan pencapaian yang telah saya raih dalam berbagai kompetisi dan kegiatan. 
            Setiap penghargaan merupakan hasil dari dedikasi, kerja keras, dan kolaborasi tim.
        </p>
        
        <div class="achievements-grid">
            <!-- Achievement 1 -->
            <div class="achievement-box">
                <i class='bx bx-medal medal-icon'></i>
                <h3 class="achievement-title">Juara 3 LKTIN Nasional Mechanical Weekend of Technology</h3>
                <p class="achievement-event">Lomba Karya Tulis Ilmiah Nasional oleh HMJ Teknik Mesin Polines</p>
                <span class="achievement-year">2024</span>
            </div>
            
            <!-- Achievement 2 -->
            <div class="achievement-box">
                <i class='bx bx-medal medal-icon'></i>
                <h3 class="achievement-title">Gold Medal IWSC Scientific Paper: Innovation Start-up Category</h3>
                <p class="achievement-event">Information Technology International Walisongo Science Competition</p>
                <span class="achievement-year">2025</span>
            </div>
        </div>
    </div>
</section>
</body>
</html>