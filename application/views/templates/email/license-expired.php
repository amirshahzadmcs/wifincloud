test<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>License Expiration Notification</title>
  </head>
  <body style="font-family: Helvetica, sans-serif; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.3; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f4f5f6; margin: 0; padding: 0;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f4f5f6; width: 100%;" width="100%" bgcolor="#f4f5f6">
      <tr>
        <td style="font-family: Helvetica, sans-serif; font-size: 16px; vertical-align: top;" valign="top">&nbsp;</td>
        <td class="container" style="font-family: Helvetica, sans-serif; font-size: 16px; vertical-align: top; max-width: 600px; padding: 0; padding-top: 24px; width: 600px; margin: 0 auto;" width="600" valign="top">
          <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 600px; padding: 0;">

            <!-- START CENTERED WHITE CONTAINER -->
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border: 1px solid #eaebed; border-radius: 16px; width: 100%;" width="100%">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: Helvetica, sans-serif; font-size: 16px; vertical-align: top; box-sizing: border-box; padding: 24px;" valign="top">
                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;">Dear {{$name}},</p>
                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;">We hope this message finds you well!</p>
                  
                  @if ($daysLeft > 0)
                   <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;">This is a friendly reminder that your software license will expire in {{$daysLeft}} days. To ensure uninterrupted access to your software and its features, we encourage you to renew your license before it expires.</p>

                   <table style="width: 100%; border-spacing: 0; margin-bottom: 20px;">
                    <tr>
                        <td style="width: 25%; padding: 10px;">
                            <div style=" border-radius: 5px; padding: 20px;">
                                <div style="font-size: 14px; font-weight: 500; color: #6c757d; margin-bottom: 1rem;">Name:
                                </div>
                                <div style="display: flex; justify-content: space-between; line-height: 1;">
                                    <span style="font-size: 14px; font-weight: 500; color: #6c757d;">{{ $name }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="width: 35%; padding: 10px;">
                            <div style=" border-radius: 5px; padding: 20px;">
                                <div style="font-size: 14px; font-weight: 500; color: #6c757d; margin-bottom: 1rem;">Registration date:                                </div>
                                <div style="display: flex; justify-content: space-between; line-height: 1;">
                                    <span style="font-size: 14px; font-weight: 500; color: #6c757d;">{{ $registration_date }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="width: 30%; padding: 10px;">
                            <div style=" border-radius: 5px; padding: 20px;">
                                <div style="font-size: 14px; font-weight: 500; color: #6c757d; margin-bottom: 1rem;">Expiry date:</div>
                                <div style="display: flex; justify-content: space-between; line-height: 1;">
                                    <span style="font-size: 14px; font-weight: 500; color: #6c757d;">{{ $expire_date }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                  @else
                    <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;">We regret to inform you that your software license has expired. This means that you may no longer have access to the software and its features.</p>
                    <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;">To restore your access and enjoy uninterrupted service, we encourage you to renew your license as soon as possible. If you have any questions or need assistance with the renewal process, please don’t hesitate to reach out.</p>
                  @endif
                  
                  
				  
                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;"></p>
                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;">Best regards.</p>
                  <p style="font-family: Helvetica, sans-serif; font-size: 16px; font-weight: normal; margin: 0; margin-bottom: 16px;"><a href="https://www.wifincloud.com/" style="color: #9a9ea6; font-size: 16px; text-align: center; text-decoration: none;">WifinCloud</a></p>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer" style="clear: both; padding-top: 24px; text-align: center; width: 100%;">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                <tr>
                  <td class="content-block" style="font-family: Helvetica, sans-serif; vertical-align: top; color: #9a9ea6; font-size: 16px; text-align: center;" valign="top" align="center">
                    <span class="apple-link" style="color: #9a9ea6; font-size: 16px; text-align: center;">Dubai - UAE</span>
                  </td>
                </tr>
                <tr>
                  <td class="content-block powered-by" style="font-family: Helvetica, sans-serif; vertical-align: top; color: #9a9ea6; font-size: 16px; text-align: center;" valign="top" align="center">
                    Powered by <a href="https://www.wifincloud.com/" style="color: #9a9ea6; font-size: 16px; text-align: center; text-decoration: none;">WifinCloud</a>
                  </td>
                </tr>
              </table>
            </div>

            <!-- END FOOTER -->
            
<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td style="font-family: Helvetica, sans-serif; font-size: 16px; vertical-align: top;" valign="top">&nbsp;</td>
      </tr>
    </table>
  </body>
</html>