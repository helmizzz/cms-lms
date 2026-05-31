# AI Customer Service Website (PHP + HTML)

## Overview

Sistem ini adalah fitur tambahan yang dapat dimasukkan ke website existing.

Konsep utama:

- User menggunakan layanan AI
- Admin mengelola sistem AI
- Backend menggunakan PHP
- Frontend menggunakan HTML/Bootstrap
- AI menggunakan API (OpenRouter/OpenAI/dll)

---

# ROLE SYSTEM

## 1. User Role

User menggunakan AI untuk:

- Generate dokumen
- Tanya jawab AI
- Revisi dokumen
- Simpan hasil
- Download hasil

### Menu User

```text
Dashboard
AI Assistant
Generate Document
History
Profile
Quota Usage

## 2. Admin Role

Admin mengelola sistem AI.

### Menu Admin

```text
Dashboard
Users
AI Logs
Prompt Templates
Packages / Quotas
Settings
System Monitoring
WORKFLOW SYSTEM
USER FLOW
Login
↓
Pilih fitur AI
↓
Isi form / prompt
↓
Backend validasi
↓
Kirim ke API AI
↓
AI generate hasil
↓
Simpan ke database
↓
Tampilkan ke user
ADMIN FLOW
Admin login
↓
Lihat dashboard
↓
Monitor penggunaan AI
↓
Kelola user
↓
Kelola prompt
↓
Kelola quota
↓
Lihat log request
TECHNOLOGY STACK
Frontend

Bebas menggunakan:

HTML
Bootstrap
Tailwind
jQuery

Rekomendasi sederhana:

HTML + Bootstrap 5
Backend

Rekomendasi:

PHP Native

Atau:

Laravel
Database
MySQL / MariaDB
Hosting
MVP
Shared Hosting
Scale Up
VPS Ubuntu
FOLDER STRUCTURE
/public
    index.php
    login.php
    register.php
    dashboard.php
    ai-chat.php
    ai-document.php
    history.php

/admin
    dashboard.php
    users.php
    prompts.php
    logs.php
    packages.php
    settings.php

/app
    auth.php
    ai_service.php
    quota_service.php
    document_service.php
    log_service.php

/config
    database.php
    env.php

/assets
    css/
    js/
    images/
DATABASE STRUCTURE
users
id
name
email
password
role
quota
created_at
ai_requests
id
user_id
prompt
response
tokens_used
status
created_at
prompt_templates
id
title
prompt
category
created_at
packages
id
name
quota_limit
price
created_at
API FLOW
Request Flow
User Input
↓
PHP Backend
↓
Validate User
↓
Check Quota
↓
Load Prompt Template
↓
Send Request to AI API
↓
Receive Response
↓
Save Database
↓
Return Response to User
SIMPLE API EXAMPLE (PHP)
ai_service.php
<?php

function askAI($prompt)
{
    $apiKey = "YOUR_API_KEY";

    $data = [
        "model" => "openai/gpt-4.1-mini",
        "messages" => [
            [
                "role" => "user",
                "content" => $prompt
            ]
        ]
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://openrouter.ai/api/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $apiKey,
        "Content-Type: application/json"
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    curl_close($ch);

    return json_decode($response, true);
}
SIMPLE USER PAGE
ai-document.php
<?php

include '../app/ai_service.php';

$result = "";

if(isset($_POST['submit']))
{
    $prompt = $_POST['prompt'];

    $response = askAI($prompt);

    $result = $response['choices'][0]['message']['content'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>AI Document</title>
</head>
<body>

<form method="POST">

    <textarea name="prompt"></textarea>

    <button type="submit" name="submit">
        Generate
    </button>

</form>

<hr>

<div>
    <?php echo nl2br($result); ?>
</div>

</body>
</html>
ADMIN FEATURES
1. User Management

Admin dapat:

melihat user
suspend user
reset quota
ubah role
2. Prompt Management

Admin dapat:

membuat template prompt
edit system prompt
kategori prompt

Contoh:

Proposal
Surat Resmi
CV
Marketing
Business Plan
3. AI Logs

Admin dapat melihat:

User mana menggunakan AI
Prompt apa yang dikirim
Berapa token digunakan
Apakah request gagal
4. Package & Quota

Contoh:

Free User = 20 request/hari
Premium = 500 request/hari