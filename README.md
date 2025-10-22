# WiFiNCloud – Cloud-Based WiFi Service

[WiFiNCloud Website](https://www.wifincloud.com)

WiFiNCloud is a cloud-based WiFi solution designed for malls, hotels, and other public spaces. It allows businesses to provide secure, seamless internet access to their customers while leveraging **Twilio API** for OTP-based authentication.

---

## Features

- **OTP Authentication via Twilio**  
  Customers verify their identity using their phone number and email. An OTP is sent via Twilio, ensuring secure access.

- **Admin Panel**  
  - Configure and manage Twilio API settings  
  - Switch or update Twilio accounts easily  
  - Monitor user activity and manage access in real-time  

- **Scalable Cloud Solution**  
  Built to handle high-traffic environments like malls and hotels with ease.

---

## How It Works

1. Customer connects to WiFi and enters their **phone number and email**.  
2. **Twilio API** sends a One-Time Password (OTP) to the customer’s phone.  
3. Customer enters the OTP to gain **secure WiFi access**.  

---

## Tech Stack

- **Backend:** Laravel  
- **Frontend:** Blade Templates / HTML / CSS / JS  
- **Database:** MySQL  
- **SMS API:** Twilio  

---

## Installation

1. Clone the repository:  
   ```bash
   git clone https://github.com/yourusername/wifincloud.git
