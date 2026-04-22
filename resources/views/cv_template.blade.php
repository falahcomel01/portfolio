<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CV - {{ $name }}</title>
    <style>
        /* === PAGE SETTINGS === */
        @page {
            size: A4;
            margin: 0;
        }

        /* === RESET & BODY === */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #222;
            font-size: 9pt;
            line-height: 1.2;
            margin: 10mm; /* Margin pas untuk printer */
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }

        /* === HEADER (Compact 2 Lines) === */
        .cv-header {
            margin-bottom: 6px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        h1 {
            font-size: 16pt;
            text-transform: uppercase;
            font-weight: 800;
            margin: 0;
            letter-spacing: 1px;
        }
        .header-meta {
            margin-top: 4px;
            font-size: 9pt;
            color: #333;
        }

        /* === SUMMARY === */
        .summary {
            text-align: justify;
            margin-bottom: 10px;
            color: #444;
        }

        /* === SECTIONS (Top) === */
        .main-section-title {
            font-size: 10.5pt;
            text-transform: uppercase;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            margin-top: 10px;
            margin-bottom: 6px;
            padding-bottom: 2px;
            color: #000;
        }

        /* === TABLES (Work/Edu/Org) === */
        .entry-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            table-layout: fixed;
        }
        .entry-table td {
            padding: 1px 0;
            vertical-align: top;
        }
        .col-title {
            width: 75%;
            font-weight: bold;
            padding-right: 5px;
        }
        .col-date {
            width: 25%;
            text-align: right;
            color: #555;
            font-size: 8.5pt;
            white-space: nowrap;
        }
        .role-italic {
            font-weight: normal;
            font-style: italic;
            color: #555;
        }
        .entry-desc {
            margin-top: 2px;
            font-weight: normal;
            color: #000;
            text-align: justify;
            font-size: 9pt;
        }
        .entry-location {
            margin-top: 2px;
            margin-bottom: 2px;
            font-size: 8.5pt;
            color: #555;
            font-style: italic;
        }

        /* === BOTTOM SPLIT SECTION (Skills & Projects) === */
        .split-container {
            margin-top: 12px;
        }
        .split-table {
            width: 100%;
            border-collapse: collapse;
        }
        .split-td-left {
            width: 35%; /* Lebar kolom Skills */
            padding-right: 15px;
            vertical-align: top;
            border-right: 1px solid #eee; /* Garis pemisah halus */
        }
        .split-td-right {
            width: 65%; /* Lebar kolom Projects */
            padding-left: 15px;
            vertical-align: top;
        }
        
        .sub-header {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 6px;
            display: block;
            background: #f9f9f9;
            padding: 3px 5px;
            border-left: 3px solid #000;
        }

        /* Skills Style */
        .skill-item {
            margin-bottom: 6px;
        }
        .skill-label {
            font-weight: bold;
            display: block;
            font-size: 8.5pt;
            color: #333;
        }
        .skill-content {
            font-size: 9pt;
        }

        /* Projects List Style */
        .project-list {
            margin: 0;
            padding-left: 15px;
            list-style-type: square;
        }
        .project-list li {
            margin-bottom: 4px; /* Jarak antar project sangat rapat */
            text-align: justify;
            font-size: 9pt;
            line-height: 1.15; /* Rapat agar muat banyak */
            color: #000;
        }
        .project-title {
            font-weight: bold;
        }

    </style>
</head>
<body>

    <div class="cv-container">
        <!-- HEADER -->
        <div class="cv-header">
            <h1>{{ $name }}</h1>
            <div class="header-meta">
                {{ $title }} | {{ $contact['email'] }} | {{ $contact['phone'] }} | {{ $contact['linkedin'] }} | {{ $contact['website'] }} | {{ $contact['address'] }}
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="summary">
            {{ $summary }}
        </div>

        <!-- WORK EXPERIENCE -->
        <div class="main-section-title">Work Experience</div>
        @foreach($work_experiences as $work)
            <table class="entry-table">
                <tr>
                    <td class="col-title">
                        {{ $work['company'] }} <span class="role-italic">- {{ $work['role'] }}</span>
                    </td>
                    <td class="col-date">{{ $work['period'] }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="entry-desc">
                        @if(!empty($work['location']))
                            <div class="entry-location">{{ $work['location'] }}</div>
                        @endif
                        {{ $work['details'] }}
                    </td>
                </tr>
            </table>
        @endforeach

        <!-- EDUCATION -->
        <div class="main-section-title">Education</div>
        @foreach($education as $edu)
            <table class="entry-table">
                <tr>
                    <td class="col-title">
                        {{ $edu['school'] }} <span class="role-italic">({{ $edu['degree'] }})</span>
                    </td>
                    <td class="col-date">{{ $edu['period'] }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="entry-desc">
                        GPA: {{ $edu['gpa'] }}
                    </td>
                </tr>
            </table>
        @endforeach

        <!-- ORGANIZATIONAL -->
        <div class="main-section-title">Organizational Experience</div>
        @foreach($organizational as $org)
            <table class="entry-table">
                <tr>
                    <td class="col-title">
                        {{ $org['org'] }} <span class="role-italic">- {{ $org['role'] }}</span>
                    </td>
                    <td class="col-date">{{ $org['period'] }}</td>
                </tr>
            </table>
        @endforeach

        <!-- BOTTOM SPLIT SECTION: SKILLS & PROJECTS -->
        <div class="split-container">
            <table class="split-table">
                <tr>
                    <!-- KOLOM KIRI: SKILLS -->
                    <td class="split-td-left">
                        <span class="sub-header">Skills</span>
                        
                        <div class="skill-item">
                            <span class="skill-label">Soft Skills:</span>
                            <div class="skill-content">{{ $skills['soft'] }}</div>
                        </div>
                        
                        <div class="skill-item">
                            <span class="skill-label">Hard Skills:</span>
                            <div class="skill-content">{{ $skills['hard'] }}</div>
                        </div>
                    </td>

                    <!-- KOLOM KANAN: PROJECTS -->
                    <td class="split-td-right">
                        <span class="sub-header">Projects</span>
                        <ul class="project-list">
                            @foreach($projects as $project)
                                <li>
                                    <span class="project-title">{{ $project['title'] }}:</span>
                                    {{ $project['description'] }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>
