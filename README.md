# 🚀 AI Website Generator (Laravel + Gemini API)

An AI-powered dynamic website generator built using Laravel, MySQL, HTML, CSS, JavaScript and Google Gemini API.

This system allows users to generate complete responsive websites automatically based on business idea, category, and design style using Generative AI.

---

## 🌟 Project Overview

The AI Website Generator is a smart SaaS-style web application where:

• User enters a website idea  
• Selects category and design  
• Backend generates structured AI prompt  
• Prompt is sent to Google Gemini API  
• AI returns full responsive HTML  
• Response is stored in MySQL  
• Website preview is rendered instantly  

This project demonstrates full-stack development with AI integration.

---

## 🧠 Core Features

✔ Prompt-based dynamic website generation  
✔ Gemini AI API integration  
✔ Automatic structured prompt creation  
✔ Pure HTML response handling (No Markdown)  
✔ Live preview using iframe  
✔ MySQL database storage  
✔ Error handling & timeout handling  
✔ Clean and responsive UI  
✔ MVC architecture (Laravel)  

---

## 🏗️ System Architecture

Frontend (HTML, CSS, JS)
        ↓
Laravel Controller
        ↓
Prompt Builder Logic
        ↓
Gemini API Call
        ↓
AI HTML Response
        ↓
Store in MySQL
        ↓
Live Preview Rendering

---

## 🛠️ Technology Stack

### Frontend
- HTML5
- CSS3
- JavaScript (Fetch API)

### Backend
- Laravel (PHP 8+)
- MVC Architecture
- REST API Handling

### Database
- MySQL

### AI Integration
- Google Gemini API (gemini-2.5-flash)

---

## 🗄️ Database Schema

Table: generated_websites

- id (Primary Key)
- business_type (string)
- category (string)
- design (string)
- prompt (longText)
- ai_response (longText)
- created_at (timestamp)
- updated_at (timestamp)

---

## 🔐 Environment Setup

1. Clone the repository
