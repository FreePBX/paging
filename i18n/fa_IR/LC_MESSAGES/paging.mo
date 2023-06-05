��    J      l  e   �      P  �   Q  >   �  �     �  �     g
     o
  ;   ~
     �
     �
     �
     �
     �
     �
          $     +     7  �   C                    %     ,     4     <     N     T  �   f     B     J     S     a     s     �     �     �     �     �     �                 c     
   |     �     �     �     �     �     �     �     �  �        �     �                               4  -   ;  �  i         2     B     V  i   m    �  ]   �     =     E  t   I  �  �  �   �  ?     �   P  �  �     �     �  .   �     �  "        /     6     S      `      �     �     �     �  �   �     �     �     �     �     �     �     �  
            �   !      �      !     !     8!  0   T!  *   �!     �!  (   �!  "   �!      "  %   5"     ["     b"     i"  �   "     )#     =#     V#     v#     �#  "   �#     �#     �#  %   �#  �   $     �$     �$     %     %     )%     8%  &   ?%  
   f%  c   q%  �  �%    �(     �)     �)  $   �)  �   *    �*  �   -     �-     �-  �   �-        *   8   3                    H   "              /   (      0   1   ;         @   D                                $   -             =                           )   %   '   .   ?         #               7       ,   C   A          J   6   5         +              I      4   !                     2       E   >   	           F   B          &          
   G   <   :   9    <strong>Force</strong><br> Send the headers telling the phone to go into auto answer mode. This may not work, and is dependant on the phone. <strong>Reject</strong><br> Return a BUSY signal to the caller <strong>Ring</strong><br> Treat the page as a normal call, and ring the extension (if Call Waiting is disabled, this will return BUSY <ul>
<li><b>"Skip"</b> will not page any busy extension. All other extensions will be paged as normal</li>
<li><b>"Force"</b> will not check if the device is in use before paging it. This means conversations can be interrupted by a page (depending on how the device handles it). This is useful for "emergency" paging groups.</li>
<li><b>"Whisper"</b> will attempt to use the ChanSpy capability on SIP channels, resulting in the page being sent to the device's earpiece "whispered" to the user but not heard by the remote party. If ChanSpy is not supported on the device or otherwise fails, no page will get through. It probably does not make too much sense to choose duplex if using Whisper mode.</li>
</ul> Actions Add Page Group Annoucement to be played to remote party. Default is a beep Applications Auto-answer defaults Beep Busy Extensions Default Default Group Inclusion Default Page Group Delete Description Device List Devices to page. Please note, paging calls the actual device (and not the user). Amount of pagable devices is restricted by the advanced setting key PAGINGMAXPARTICIPANTS and is currently set to  Disable Disabled Drop Silence Duplex Enabled Exclude Extension Options Force Group Description If you choose to make a Page Group the "default" page group, a checkbox will appear in the Extensions Module that will allow you to include or exclude that Extension in the default Page Group when editing said extension Include Intercom Intercom Mode Intercom Override Intercom from %s: Disabled Intercom from %s: Enabled Intercom prefix Intercom: Disabled Intercom: Enabled Internal Auto Answer List Page Groups No None Not Selected Override the speaker volume for this page. Note: This is only valid for Sangoma phones at this time Page Group Page Group:  Page Group: %s (%s) Page Groups Paging Extension Paging Group %s : %s Paging Groups Paging and Intercom Paging and Intercom settings Paging is typically one way for announcements only. Checking this will make the paging duplex, allowing all phones in the paging group to be able to talk and be heard by all. This makes it like an "instant conference" Reject Reset Ring Selected Settings Skip Speaker Volume Override Submit The number users will dial to page this group This module is for specific phones that are capable of Paging or Intercom. This section is for configuring group paging, intercom is configured through <strong>Feature Codes</strong>. Intercom must be enabled on a handset before it will allow incoming calls. It is possible to restrict incoming intercom calls to specific extensions only, or to allow intercom calls from all extensions but explicitly deny from specific extensions.<br /><br />This module should work with Aastra, Grandstream, Linksys/Sipura, Mitel, Polycom, SNOM , and possibly other SIP phones (not ATAs). Any phone that is always set to auto-answer should also work (such as the console extension if configured). This option drops what Asterisk detects as silence from entering into the bridge. Enabling this option will drastically improve performance and help remove the buildup of background noise from the conference. Highly recommended for large conferences due to its performance enhancements. Unknown Request User Intercom Allow User Intercom Disallow When Enabled users can use *80<ext> to force intercom. When Disabled this user will reject intercom calls When set to Intercom, calls to this extension/user from other internal users act as if they were intercom calls meaning they will be auto-answered if the endpoint supports this feature and the system is configured to operate in this mode. All the normal white list and black list settings will be honored if they are set. External calls will still ring as normal, as will certain other circumstances such as blind transfers and when a Follow Me is configured and enabled. If Disabled, the phone rings as a normal phone. When using Intercom to page an extension, if the extension is in use, you have three options. Whisper Yes You can include or exclude this extension/device from being part of the default page group when creating or editing. Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2023-06-05 03:10+0000
PO-Revision-Date: 2016-08-21 05:58+0200
Last-Translator: Media <mousavi.media@gmail.com>
Language-Team: Persian (Iran) <http://weblate.freepbx.org/projects/freepbx/paging/fa_IR/>
Language: fa_IR
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Weblate 2.4
 <strong>Force</strong><br> Send the headers telling the phone to go into auto answer mode. This may not work, and is dependant on the phone . <strong>Reject </strong><br> Return a BUSY signal to the caller <strong>Ring</strong><br> Treat the page as a normal call , and ring the extension (if Call Waiting is disabled, this will return BUSY <ul>
<li><b>"Skip"</b> will not page any busy extension . All other extensions will be paged as normal</li>
<li><b>"Force"</b> will not check if the device is in use before paging it. This means conversations can be interrupted by a page (depending on how the device handles it). This is useful for "emergency" paging groups.</li>
<li><b>"Whisper"</b> will attempt to use the ChanSpy capability on SIP channels, resulting in the page being sent to the device's earpiece "whispered" to the user but not heard by the remote party. If ChanSpy is not supported on the device or otherwise fails, no page will get through. It probably does not make too much sense to choose duplex if using Whisper mode.</li>
</ul> عملیات افزودن گروه صفحه اعلان پخش شده برای remote party برنامه‌ ها پاسخ خودکار پیشفرض بوق داخلی های مشغول پیشفرض ظرفیت گروه پیشفرض گروه اعلان پیشفرض حذف شرح فهرست وسیله Devices to page . Please note, paging calls the actual device (and not the user). Amount of pagable devices is restricted by the advanced setting key PAGINGMAXPARTICIPANTS and is currently set to  غیرفعال غیر فعال شده شکستن سکوت تکراری فعال شد خروج گزینه های داخلی اجبار شرح گروه If you choose to make a Page Group the "default" page group , a checkbox will appear in the Extensions Module that will allow you to include or exclude that Extension in the default Page Group when editing said extension ورود تماس داخلی حالت تماس داخلی بازنویسی ورودی تماس داخلی از %s: غیرفعال شد تماس داخلی از %s: فعال شد پیشوند ورودی تماس داخلی: غیرفعال شد تماس داخلی: فعال شد پاسخ خودکار داخلی فهرست گروه های اعلان خیر هیچ انتخاب نشده ابطال صدای بلندگو برای این صفحه. نکته:این گزینه در حال حاضر فقط برای تلفن های سنگوما معتبر است گروه اعلان گروه اعلان ：  گروه اعلان ： %s (%s) گروه اعلان داخلی اعلان گروه صفحه بندی %s : %s گروه های اعلان اعلان و ورود تنظیمات اعلان و ورود Paging is typically one way for announcements only. Checking this will make the paging duplex, allowing all phones in the paging group to be able to talk and be heard by all . This makes it like an "instant conference" لغو بازنشانی زنگ انتخاب شده تنظیمات لغو بازنویسی صدای بلندگو ارسال شماره ای که کاربران برای اعلان این گروه استفاده میکنند This module is for specific phones that are capable of Paging or Intercom. This section is for configuring group paging , intercom is configured through <strong>Feature Codes</strong>. Intercom must be enabled on a handset before it will allow incoming calls. It is possible to restrict incoming intercom calls to specific extensions only, or to allow intercom calls from all extensions but explicitly deny from specific extensions.<br /><br />This module should work with Aastra, Grandstream, Linksys/Sipura, Mitel, Polycom, SNOM , and possibly other SIP phones (not ATAs). Any phone that is always set to auto-answer should also work (such as the console extension if configured). This option drops what Asterisk detects as silence from entering into the bridge . Enabling this option will drastically improve performance and help remove the buildup of background noise from the conference. Highly recommended for large conferences due to its performance enhancements. درخواست نامعتبر کاربر ورودی مجاز کاربر ورودی غیرمجاز هنگامی که فعال شده باشد کاربران میتوانند از *80<ext> برای پاسخ تماس داخلی استفاده کنند. در هنگام غیر فعال بودن تماسهای داخلی کاربر رد میشود When set to  Intercom, calls to this extension/user from other internal users act as if they were intercom calls meaning they will be auto-answered if the endpoint supports this feature and the system is configured to operate in this mode. All the normal white list and black list settings will be honored if they are set. External calls will still ring as normal, as will certain other circumstances such as blind transfers and when a Follow Me is configured and enabled. If Disabled, the phone rings as a normal phone. زمان استفاده از ورودی برای اعلان یک داخلی, اگر داخلی مشغول باشد, شما سه گزینه دارید. نجوا بله شما میتوانید در هنگام ساختن یک گروه اعلان  داخلی ها/دستگاه ها را به این گروه اعلان وارد کرده و یا خارج نمایید. 