<?php

namespace Modules\NotificationTemplate\Trait;
use Modules\NotificationTemplate\Models\NotificationTemplate;
 
trait NotificationTemplateTrait
{
    public function addNotificationTemplate($adminId)
    {
        $template = NotificationTemplate::create([
            'type' => 'new_booking',
            'name' => 'new_booking',
            'label' => 'Booking confirmation',
            'status' => 1,
            'to' => '["admin", "user"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);

        // Notification template for admin
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Thank you for choosing our services! Your booking has been successfully confirmed. We look forward to serving you and providing an exceptional experience. Stay tuned for further updates.',
            'status' => 1,
            'user_type' => 'admin',
            'template_detail' => '
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Subject: Appointment Confirm - Thank You!</span>
            </p>
            <p><strong id="docs-internal-guid-7d6bdcce-7fff-5035-731b-386f9021a5db" style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Dear [[ user_name ]],</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We are delighted to inform you that your appointment has been successfully confirmed! Thank you for choosing our services. We are excited to have you as our valued customer and are committed to providing you with a wonderful experience.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <h4>Appointment Details</h4>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment ID: [[ id ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment Date: [[ booking_date ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Service/Event: [[ booking_services_names ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Date: [[ booking_date ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Time: [[ booking_time ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Location: [[ venue_address ]]</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We want to assure you that we have received your appointment details and everything is in order. Our team is eagerly preparing to make this a memorable experience for you. If you have any specific requirements or questions regarding your appointment, please feel free to reach out to us.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We recommend marking your calendar and setting a reminder for the date and time of the event to ensure you don\'t miss your appointment. Should there be any updates or changes to your appointment, we will promptly notify you.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Once again, thank you for choosing our services. We look forward to providing you with exceptional service and creating lasting memories. If you have any further queries, please do not hesitate to contact our friendly customer support team.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Best regards,</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_fullname ]],</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_role ]],</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_name ]],</span>
            </p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_contact_info ]]</span>
            </p>
            <p><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">&nbsp;</span></p>
            ',
            'subject' => 'Booking Confirmation Received!',
            'notification_subject' => 'New Booking Alert.',
            'notification_template_detail' => '<p>New booking: [[ user_name ]] has booked [[ booking_services_names ]].</p>',
            'created_by' => $adminId,
        ]);


        // Notification template for manager


        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Thank you for choosing our services! Your booking has been successfully confirmed. We look forward to serving you and providing an exceptional experience. Stay tuned for further updates.',
            'status' => 1,
            'user_type' => 'user',
            'template_detail' => '
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Subject: Appointment Confirm - Thank You!</span>
            </p>
            <p><strong id="docs-internal-guid-7d6bdcce-7fff-5035-731b-386f9021a5db" style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Dear [[ user_name ]],</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We are delighted to inform you that your appointment has been successfully confirmed! Thank you for choosing our services. We are excited to have you as our valued customer and are committed to providing you with a wonderful experience.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <h4>Appointment Details</h4>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment ID: [[ id ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment Date: [[ booking_date ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Service/Event: [[ booking_services_names ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Date: [[ booking_date ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Time: [[ booking_time ]]</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Location: [[ venue_address ]]</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We want to assure you that we have received your appointment details and everything is in order. Our team is eagerly preparing to make this a memorable experience for you. If you have any specific requirements or questions regarding your appointment, please feel free to reach out to us.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We recommend marking your calendar and setting a reminder for the date and time of the event to ensure you don\'t miss your appointment. Should there be any updates or changes to your appointment, we will promptly notify you.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Once again, thank you for choosing our services. We look forward to providing you with exceptional service and creating lasting memories. If you have any further queries, please do not hesitate to contact our friendly customer support team.</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Best regards,</span>
            </p>
            <p><strong style="font-weight: normal;">&nbsp;</strong></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_fullname ]],</span>
            </p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">
            <span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_name ]]</span>
            </p>
            ',
            'subject' => 'Booking Confirmation Received!',
            'notification_subject' => 'Booking Confirmed',
            'notification_template_detail' => 'We are delighted to confirm your appointment. Thank you for choosing our services. See details below.',
            'created_by' => $adminId,
        ]);



        $template = NotificationTemplate::create([
            'type' => 'check_in_booking',
            'name' => 'check_in_booking',
            'label' => 'Check-In On Booking',
            'status' => 1,
            'to' => '["user"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Welcome to your booked accommodation. We hope you have a pleasant stay!',
            'status' => 1,
            'user_type' => 'user',
            'template_detail' => '<p><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Subject: Appointment C<span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; white-space-collapse: collapse;">heck in</span> - Thank You!</span></p>
            <p><span id="docs-internal-guid-7d6bdcce-7fff-5035-731b-386f9021a5db">&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Dear [[ user_name ]],</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">Welcome to your booked accommodation. We hope you have a pleasant stay!</p>
            <p>&nbsp;</p>
            <h4>Appointment Details</h4>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment ID: [[ id ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment Date: [[ booking_date ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Service/Event: [[ booking_services_names ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Date: [[ booking_date ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Time: [[ booking_time ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Location: [[ venue_address ]]</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We want to assure you that we have received your appointment details and everything is in order. Our team is eagerly preparing to make this a memorable experience for you. If you have any specific requirements or questions regarding your appointment, please feel free to reach out to us.</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We recommend marking your calendar and setting a reminder for the date and time of the event to ensure you don\'t miss your appointment. Should there be any updates or changes to your appointment, we will promptly notify you.</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Once again, thank you for choosing our services. We look forward to providing you with exceptional service and creating lasting memories. If you have any further queries, please do not hesitate to contact our friendly customer support team.</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Best regards,</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_fullname ]],</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_role ]],</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_name ]],</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_contact_info ]]</span></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">&nbsp;</span></p>',
            'subject' => 'Check-in Successful!',
            'notification_subject' => 'Check-in Successful!',
            'notification_template_detail' => '<p>Welcome to your booked accommodation. We hope you have a pleasant stay!</p>',
            'created_by' => $adminId,
        ]);

        $template = NotificationTemplate::create([
            'type' => 'checkout_booking',
            'name' => 'checkout_booking',
            'label' => 'Checkout On Booking',
            'status' => 1,
            'to' => '["user"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Thank you for choosing our services. Please remember to check out by [check-out time]. We hope you had a wonderful experience!',
            'status' => 1,
            'user_type' => 'user',
            'template_detail' => '<p><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Subject: Appointment C<span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; white-space-collapse: collapse;">heck out</span> - Thank You!</span></p>
            <p><span id="docs-internal-guid-7d6bdcce-7fff-5035-731b-386f9021a5db">&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Dear [[ user_name ]],</span></p>
            <p><span>&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;">Thank you for choosing our services. Please remember to check out by [check-out time]. We hope you had a wonderful experience!</p>
            <p><span>&nbsp;</span></p>
            <h4>Appointment Details</h4>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment ID: [[ id ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Appointment Date: [[ booking_date ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Service/Event: [[ booking_services_names ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Date: [[ booking_date ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Time: [[ booking_time ]]</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Location: [[ venue_address ]]</span></p>
            <p><span>&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We want to assure you that we have received your appointment details and everything is in order. Our team is eagerly preparing to make this a memorable experience for you. If you have any specific requirements or questions regarding your appointment, please feel free to reach out to us.</span></p>
            <p><span>&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">We recommend marking your calendar and setting a reminder for the date and time of the event to ensure you don\'t miss your appointment. Should there be any updates or changes to your appointment, we will promptly notify you.</span></p>
            <p><span>&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Once again, thank you for choosing our services. We look forward to providing you with exceptional service and creating lasting memories. If you have any further queries, please do not hesitate to contact our friendly customer support team.</span></p>
            <p><span>&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Best regards,</span></p>
            <p><span>&nbsp;</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_fullname ]],</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ logged_in_user_role ]],</span></p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_name ]],</span></p>
            <p>&nbsp;</p>
            <p dir="ltr" style="line-height: 1.38; margin-top: 0pt; margin-bottom: 0pt;"><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">[[ company_contact_info ]]</span></p>
            <p>&nbsp;</p>
            <p><span style="font-size: 11pt; font-family: Arial; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">&nbsp;</span></p>',
            'subject' => 'Check-out Reminder',
            'notification_subject' => 'Check-out Reminder',
            'notification_template_detail' => '<p>Thank you for choosing our services. Please remember to check out by [check-out time]. We hope you had a wonderful experience!</p>',
            'created_by' => $adminId,
        ]);

        $template = NotificationTemplate::create([
            'type' => 'complete_booking',
            'name' => 'complete_booking',
            'label' => 'Complete On Booking',
            'status' => 1,
            'to' => '["user"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Congratulations! Your booking has been successfully completed. We appreciate your business and look forward to serving you again.',
            'status' => 1,
            'user_type' => 'user',
            'language' => 'en',
            'template_detail' => '<p>Subject: Appointment Completion and Invoice</p>
            <p>&nbsp;</p>
            <p>Dear [[ user_name ]],</p>
            <p>&nbsp;</p>
            <p>We are writing to inform you that your recent appointment with us has been successfully completed. We sincerely appreciate your trust in our services and the opportunity to serve you.</p>
            <p>&nbsp;</p>
            <p>[[ company_name ]]</p>',
            'subject' => 'Appointment complete email with invoice',
            'notification_subject' => 'Appointment complete email with invoice',
            'notification_template_detail' => '<p>We are writing to inform you that your recent appointment with us has been successfully completed.</p>',
            'created_by' => $adminId,
        ]);


        $template = NotificationTemplate::create([
            'type' => 'cancel_booking',
            'name' => 'cancel_booking',
            'label' => 'Cancel On Booking',
            'status' => 1,
            'to' => '["user"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'We regret to inform you that your booking has been cancelled. If you have any questions or need further assistance, please contact our support team.',
            'status' => 1,
            'user_type' => 'user',
            'template_detail' => '<p>Dear [[ user_name ]],</p>
            <p>&nbsp;</p>
            <p>We regret to inform you that your booking has been cancelled. If you have any questions or need further assistance, please contact our support team.</p>
            <p>&nbsp;</p>
            <p>Thank you for your understanding.</p>
            <p>&nbsp;</p>
            <p>Best regards,</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>[[ company_name ]]</p>',
            'subject' => 'Booking Cancellation',
            'notification_subject' => 'Important: Booking Cancellation Notice',
            'notification_template_detail' => '<p><span style="font-family: Arial; font-size: 14.6667px; white-space-collapse: preserve;">We regret to inform you that your booking has been cancelled. If you have any questions or need further assistance, please contact our support team.</span></p>',
            'created_by' => $adminId,
        ]);
        $template = NotificationTemplate::create([
            'type' => 'quick_booking',
            'name' => 'quick_booking',
            'label' => 'Quick Booking',
            'status' => 1,
            'to' => '["user"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'status' => 1,
            'user_type' => 'user',
            'subject' => 'Quick Booking',
            'template_detail' => '
                <p>We are pleased to inform you that your appointment has been successfully booked. We value your time and are committed to providing you with excellent service.</p>
            ',
            'notification_subject' => 'Your Appointment Confirmation',
            'notification_template_detail' => '
                <p>Dear [[ user_name ]],</p>
                <p>&nbsp;</p>
                <p>Your appointment has been confirmed. Below are the details:</p>
                <p>&nbsp;</p>
                <p>Appointment Date: [[ booking_date ]]</p>
                <p>Appointment Time: [[ booking_time ]]</p>
                <p>Appointment Duration: [[ booking_duration ]]</p>
                <p>Location: [[ venue_address ]]</p>
                <p>&nbsp;</p>
                <p>Please arrive a few minutes early to ensure a smooth experience. If you need to reschedule or cancel, notify us at least [[ link ]] in advance.</p>
                <p>&nbsp;</p>
                <p>Thank you for choosing our services.</p>
                <p>&nbsp;</p>
                <p>Best regards,</p>
                <p>&nbsp;</p>
                <p>[[ company_name ]]</p>
            ',
            'created_by' => $adminId,
        ]);


        $template = NotificationTemplate::create([
            'type' => 'change_password',
            'name' => 'change_password',
            'label' => 'Change Password',
            'status' => 1,
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'status' => 1,
            'subject' => 'Change Password',
            'template_detail' => '
            <p>Subject: Password Change Confirmation</p>
            <p>Dear [[ user_name ]],</p>
            <p>&nbsp;</p>
            <p>We wanted to inform you that a recent password change has been made for your account. If you did not initiate this change, please take immediate action to secure your account.</p>
            <p>&nbsp;</p>
            <p>To regain control and secure your account:</p>
            <p>&nbsp;</p>
            <p>Visit [[ link ]].</p>
            <p>Follow the instructions to verify your identity.</p>
            <p>Create a strong and unique password.</p>
            <p>Update passwords for any other accounts using similar credentials.</p>
            <p>If you have any concerns or need assistance, please contact our customer support team.</p>
            <p>&nbsp;</p>
            <p>Thank you for your attention to this matter.</p>
            <p>&nbsp;</p>
            <p>Best regards,</p>
            <p>[[ logged_in_user_fullname ]]<br />[[ logged_in_user_role ]]<br />[[ company_name ]]</p>
            <p>[[ company_contact_info ]]</p>
        ',
            'created_by' => $adminId,
        ]);

        $template = NotificationTemplate::create([
            'type' => 'forget_email_password',
            'name' => 'forget_email_password',
            'label' => 'Forget Email/Password',
            'status' => 1,
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => '',
            'status' => 1,
            'subject' => 'Forget Email/Password',
            'template_detail' => '
            <p>Subject: Password Reset Instructions</p>
            <p>&nbsp;</p>
            <p>Dear [[ user_name ]],</p>
            <p>A password reset request has been initiated for your account. To reset your password:</p>
            <p>&nbsp;</p>
            <p>Visit [[ link ]].</p>
            <p>Enter your email address.</p>
            <p>Follow the instructions provided to complete the reset process.</p>
            <p>If you did not request this reset or need assistance, please contact our support team.</p>
            <p>&nbsp;</p>
            <p>Thank you.</p>
            <p>&nbsp;</p>
            <p>Best regards,</p>
            <p>[[ logged_in_user_fullname ]]<br />[[ logged_in_user_role ]]<br />[[ company_name ]]</p>
            <p>[[ company_contact_info ]]</p>
            <p>&nbsp;</p>
        ',
            'created_by' => $adminId,
        ]);

 



        // Creating the purchase plan notification template
        $template = NotificationTemplate::create([
            'type' => 'purchase_plan',
            'name' => 'purchase_plan',
            'label' => 'Purchase Plan',
            'created_by' => 1,
            'status' => 1,
            'to' => '["super admin"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);

        // User notification template for purchase plan
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Thank you for purchasing a plan with us.',
            'status' => 1,
            'user_type' => 'user',
            'template_detail' => '<p>Dear [[ user_name ]],</p>
            <p>Thank you for purchasing the [[ plan_name ]] plan. We are excited to have you on board. You can start enjoying the benefits of your plan immediately.</p>
            <p>Plan Name: [[ plan_name ]]</p>
            <p>Plan Start Date: [[ plan_start_date ]]</p>
            <p>Plan Expiry Date: [[ plan_expiry_date ]]</p>
            <p>If you have any questions or need assistance, feel free to contact us.</p>
            <p>Best regards,</p>
            <p>[[ company_name ]]</p>',
            'subject' => 'Plan Purchase Confirmation',

            'notification_subject' => 'Your Plan Purchase is Confirmed!',
            'notification_template_detail' => '<p>Thank you for purchasing the [[ plan_name ]] plan. You can start enjoying the benefits of your plan immediately.</p>',
            'created_by' => $adminId,
        ]);

        // Admin notification template for purchase plan
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'A user has purchased a plan.',
            'status' => 1,
            'user_type' => 'admin',
            'language' => 'en',
            'template_detail' => '<p>Dear [[ company_name ]],</p>
            <p>A user has purchased the [[ plan_name ]] plan. Please review the purchase details and ensure that the user has access to the purchased plan.</p>
            <p>Plan Name: [[ plan_name ]]</p>
            <p>Purchase Date: [[ plan_start_date ]]</p>
            <p>User Name: [[ user_name ]]</p>
            <p>Best regards,</p>
            <p>[[ company_name ]]</p>',
            'subject' => 'New Plan Purchase',

            'notification_subject' => 'User Plan Purchase Alert',
            'notification_template_detail' => '<p>A user has purchased the [[ plan_name ]] plan. Please review the purchase details and take necessary actions.</p>',
            'created_by' => $adminId,
        ]);

        // Creating the user registration notification template
        $template = NotificationTemplate::create([
            'type' => 'user_registered',
            'name' => 'user_registered',
            'label' => 'User Registered',
            'created_by' => 1,
            'status' => 1,
            'to' => '["super admin"]',
            'channels' => ['IS_MAIL' => '1', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);

        // User notification template for user registration
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'Welcome to our platform! Your registration was successful.',
            'status' => 1,
            'user_type' => 'user',
            'template_detail' => '<p>Dear [[ user_name ]],</p>
            <p>Welcome to [[ company_name ]]! We are excited to have you on board. Your registration was successful, and you can now access all of our platform’s features.</p>
            <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
            <p>Best regards,</p>
            <p>[[ company_name ]]</p>',
            'subject' => 'User Registration',

            'notification_subject' => 'Registration Successful!',
            'notification_template_detail' => '<p>Welcome to [[ company_name ]]! Your registration was successful, and you can now access all features.</p>',
            'created_by' => $adminId,
        ]);

        // Admin notification template for user registration
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'A new user has registered on the platform.',
            'status' => 1,
            'user_type' => 'admin',
            'template_detail' => '<p>Dear [[ company_name ]],</p>
            <p>A new user has registered on [[ company_name ]]. Please review their details and approve their account if necessary.</p>
            <p>User Name: [[ user_name ]]</p>
            <p>Registration Date: [[ registration_date ]]</p>
            <p>Email: [[ user_email ]]</p>
            <p>Best regards,</p>
            <p>[[ company_name ]]</p>',
            'subject' => 'New User Registration',

            'notification_subject' => 'New User Registered!',
            'notification_template_detail' => '<p>A new user has registered on [[ company_name ]]. Please review their details.</p>',
            'created_by' => $adminId,
        ]);

        $template = NotificationTemplate::create([
            'type' => 'new_subscription',
            'name' => 'new_subscription',
            'label' => 'New User Subscribed',
            'status' => 1,
            'to' => '["super admin","admin"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'A new user has subscribed',
            'status' => 1,
            'user_type' => 'admin',
            'subject' => 'New User is subscribe!',
            'notification_subject' => 'New User is subscribe!',
            'notification_template_detail' => 'A new user has subscribed',
            'mail_subject' => 'New Subscription Plan Activated',
            'whatsapp_subject' => 'New Subscription Plan Activated',
            'sms_subject' => 'New Subscription Plan Activated',
            'template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'whatsapp_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'sms_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'mail_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'A new user has subscribed',
            'status' => 1,
            'user_type' => 'super admin',
            'subject' => 'New User is subscribe!',
            'template_detail' => 'A new user has subscribed',
            'notification_subject' => 'New User is subscribe!',
            'notification_template_detail' => 'A new user has subscribed',
            'mail_subject' => 'New Subscription Plan Activated',
            'whatsapp_subject' => 'New Subscription Plan Activated',
            'sms_subject' => 'New Subscription Plan Activated',
            'template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'whatsapp_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'sms_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'mail_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'created_by' => $adminId,
        ]);
        
        $template = NotificationTemplate::create([
            'type' => 'cancel_subscription',
            'name' => 'cancel_subscription',
            'label' => 'User Cancel Subscription',
            'status' => 1,
            'to' => '["admin","super admin"]',
            'channels' => ['IS_MAIL' => '0', 'PUSH_NOTIFICATION' => '1', 'IS_CUSTOM_WEBHOOK' => '0'],
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'A user has Cancel subscription',
            'status' => 1,
            'user_type' => 'admin',
            'subject' => 'A User is Cancel subscribe!',
            'template_detail' => 'A user has Cancel subscription',
            'notification_subject' => 'A User is Cancel subscribe!',
            'notification_template_detail' => 'A user has Cancel subscription',
            'mail_subject' => 'New Subscription Plan Activated',
            'whatsapp_subject' => 'New Subscription Plan Activated',
            'sms_subject' => 'New Subscription Plan Activated',
            'template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'whatsapp_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'sms_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'mail_template_detail' => '<p>[[ username ]] has subscribed to a new [[ name ]].</p>',
            'created_by' => $adminId,
        ]);
        $template->defaultNotificationTemplateMap()->create([
            'language' => 'en',
            'notification_link' => '',
            'notification_message' => 'A user has Cancel subscription',
            'status' => 1,
            'user_type' => 'super admin',
            'subject' => 'A User is Cancel subscribe!',
            'template_detail' => 'A user has Cancel subscription',
            'notification_subject' => 'A User is Cancel subscribe!',
            'notification_template_detail' => 'A user has Cancel subscription',
            'mail_subject' => 'New Subscription Plan Activated',
            'whatsapp_subject' => 'New Subscription Plan Activated',
            'sms_subject' => 'New Subscription Plan Activated',
            'template_detail' => '<p>[[ username ]] has Cancel subscription Plan [[ name ]].</p>',
            'whatsapp_template_detail' => '<p>[[ username ]] has Cancel subscription Plan [[ name ]].</p>',
            'sms_template_detail' => '<p>[[ username ]] has Cancel subscription Plan [[ name ]].</p>',
            'mail_template_detail' => '<p>[[ username ]] has Cancel subscription Plan [[ name ]].</p>',
            'created_by' => $adminId,
        ]);
    }
}
