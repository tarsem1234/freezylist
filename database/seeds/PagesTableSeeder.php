<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pages')->delete();

        \DB::table('pages')->insert([
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => null,
                'created_at' => '2018-09-07 12:44:23',
            ],
            [
                'title' => 'Advertise',
                'slug' => 'advertise',
                'content' => null,
                'created_at' => '2018-09-07 12:44:23',
            ],
            [
                'title' => 'Help',
                'slug' => 'help',
                'content' => '<h3><strong>ll help pages, whatever their individual characteristics, have some common features.</strong></h3><hr />
                    <p>The pages must be clear and illustrative.</p>
                    <p>They should have a short, descriptive explanation of each topic that can be read quickly. Users who come to help pages are usually already confused, so they aren&rsquo;t inclined to read long blocks of text.</p>
                    <p>Following good scanning aids (such as bolding keywords) can increase readability.</p>',
                'created_at' => '2018-09-07 12:44:23',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h3><strong>NARWHAL REALTY, INC. [OPERATING AS FREEZYLIST.COM] PRIVACY POLICY</strong></h3>
                    <p>Narwhal Realty, Inc. [Operating as Freezylist.com] (the &ldquo;Company&rdquo;) is committed to maintaining robust privacy protections for its users.&nbsp; Our Privacy Policy (&ldquo;Privacy Policy&rdquo;) is designed to help you understand how we collect, use and safeguard the information you provide to us and to assist you in making informed decisions when using our Service.&nbsp;</p>
                    <p>For purposes of this Agreement, &ldquo;Service&rdquo; refers to the Company&rsquo;s services which can be accessed via our website at&nbsp;<a href="http://freezylist.lusites.xyz/">freezylist.lusites.xyz</a>. The terms &ldquo;we,&rdquo; &ldquo;us,&rdquo; and &ldquo;our&rdquo; refer to the Company. &ldquo;You&rdquo; refers to you, as a user of Service. By accepting our Privacy Policy and Terms of Use (found here:<a href="http://freezylist.lusites.xyz/term-of-use-&amp;-limited-liability">freezylist.lusites.xyz/term-of-use-&amp;-limited-liability</a>), you consent to our collection, storage, use and disclosure of your personal information as described in this Privacy Policy.</p>
                    <hr />
                    <h3><strong>II.NFORMATION WE COLLECT</strong></h3>
                    <p>We collect &ldquo;Non-Personal Information&rdquo; and &ldquo;Personal Information.&rdquo;&nbsp; Non-Personal Information includes information that cannot be used to personally identify you, such as anonymous usage data, general demographic information we may collect, referring/exit pages and URLs, platform types, preferences you submit and preferences that are generated based on the data you submit and number of clicks.&nbsp; Personal Information includes only your email, which you submit to us through the registration process at the Site.</p>
                    <h2><strong>Information collected via Technology</strong></h2>
                    <p>In an effort to improve the quality of the Service, we track information provided to us by your browser or by our software application when you view or use the Service, such as the website you came from (known as the &ldquo;referring URL&rdquo;), the type of browser you use, the device from which you connected to the Service, the time and date of access, and other information that does not personally identify you.&nbsp; We track this information using cookies, or small text files which include an anonymous unique identifier.&nbsp; Cookies are sent to a user&rsquo;s browser from our servers and are stored on the user&rsquo;s computer hard drive.&nbsp; Sending a cookie to a user&rsquo;s browser enables us to collect Non-Personal information about that user and keep a record of the user&rsquo;s preferences when utilizing our services, both on an individual and aggregate basis.</p>
                    <p>The Company may use both persistent and session cookies; persistent cookies remain on your computer after you close your session and until you delete them, while session cookies expire when you close your browser.</p>

                    <h2><strong>Information you provide us by registering for an account&nbsp;</strong></h2>

                    <p>In addition to the information provided automatically by your browser when you visit the Site, to become a subscriber to the Service you will need to create a personal profile.&nbsp; You can create a profile by registering with the Service and entering your email address and other personal information, and creating a user name and a password.&nbsp; By registering, you are authorizing us to collect, store and use your email address and personal information in accordance with this Privacy Policy.</p>

                    <hr />
                    <h3><strong>II.HOW WE USE AND SHARE INFORMATION</strong></h3>

                    <h2><strong>Personal Information</strong></h2>

                    <p>Except as otherwise stated in this Privacy Policy, we do not sell, trade, rent or otherwise share for marketing purposes your Personal Information with third parties without your consent. We do share Personal Information with vendors who are performing services for the Company, such as the servers for our email communications who are provided access to user&rsquo;s email address for purposes of sending emails from us.&nbsp; Those vendors use your Personal Information only at our direction and in accordance with our Privacy Policy.</p>

                    <p>In general, the Personal Information you provide to us is used to help us communicate with you and to optimize the services for our users.&nbsp; For example, we use Personal Information to contact users in response to questions, solicit feedback from users, provide technical support, enhance the user experience, and inform users about promotional offers.</p>

                    <p>The Services are not designed for persons under age 16 - We will not knowingly collect personally identifiable information on these individuals. Registration of a user under the age of 16 violates the Freezylist Terms of Use.</p>

                    <h2><strong>Non-Personal Information</strong></h2>

                    <p>In general, we use Non-Personal Information to help us improve the Service and customize the user experience.&nbsp; We also aggregate Non-Personal Information in order to track trends and analyze use patterns on the Site.&nbsp; This Privacy Policy does not limit in any way our use or disclosure of Non-Personal Information and we reserve the right to use and disclose such Non-Personal Information to our partners, advertisers and other third parties at our discretion.</p>

                    <p>In the event we undergo a business transaction such as a merger, acquisition by another company, or sale of all or a portion of our assets, your Personal Information may be among the assets transferred.&nbsp; You acknowledge and consent that such transfers may occur and are permitted by this Privacy Policy, and that any acquirer of our assets may continue to process your Personal Information as set forth in this Privacy Policy.&nbsp; If our information practices change at any time in the future, we will post the policy changes to the Site so that you may opt out of the new information practices.&nbsp; We suggest that you check the Site periodically if you are concerned about how your information is used.</p>

                    <p>At Freezylist, we are dedicated to the safety of our members. If we have a good faith belief that access, use, preservation or disclosure of the Personal Information is reasonably necessary to (i) satisfy any requirement of law, regulation, legal process, or enforceable governmental request, (ii) enforce or investigate a potential violation of the Terms of Use, (iii) detect, prevent, or otherwise respond to fraud, security or technical concerns, (iv) support auditing and compliance functions, or (v) protect the rights, property, or safety of Narwhal Realty, Inc., its users, or the public against harm.</p>

                    <hr />
                    <h3><strong>III.HOW WE PROTECT INFORMATION</strong></h3>

                    <p>We implement security measures designed to protect your information from unauthorized access.&nbsp; Your account is protected by your account password and we urge you to take steps to keep your personal information safe by not disclosing your password and by logging out of your account after each use.&nbsp; We further protect your information from potential security breaches by implementing certain technological security measures including encryption, firewalls and secure socket layer technology.&nbsp; However, these measures do not guarantee that your information will not be accessed, disclosed, altered or destroyed by breach of such firewalls and secure server software.&nbsp; By using our Service, you acknowledge that you understand and agree to assume these risks.</p>

                    <hr />
                    <h3><strong>IV.YOUR RIGHTS REGARDING THE USE OF YOUR PERSONAL INFORMATION</strong></h3>

                    <p>You have the right at any time to prevent us from contacting you for marketing purposes.&nbsp; When we send a promotional communication to a user, the user can opt out of further promotional communications by following the unsubscribe instructions provided in each promotional e-mail.&nbsp; You can also indicate that you do not wish to receive marketing communications from us in the &ldquo;Settings&rdquo; section of the Site.&nbsp; Please note that notwithstanding the promotional preferences you indicate by either unsubscribing or opting out in the Settings section of the Site, we may continue to send you administrative emails including, for example, periodic updates to our Privacy Policy.</p>

                    <hr />
                    <h3><strong>V.LINKS TO OTHER WEBSITES</strong></h3>

                    <p>As part of the Service, we may provide links to or compatibility with other websites or applications.&nbsp; However, we are not responsible for the privacy practices employed by those websites or the information or content they contain.&nbsp; This Privacy Policy applies solely to information collected by us through the Site and the Service.&nbsp; Therefore, this Privacy Policy does not apply to your use of a third party website accessed by selecting a link on our Site or via our Service.&nbsp; To the extent that you access or use the Service through or on another website or application, then the privacy policy of that other website or application will apply to your access or use of that site or application.&nbsp; We encourage our users to read the privacy statements of other websites before proceeding to use them.</p>

                    <hr />
                    <h3><strong>VI.CHANGES TO OUR PRIVACY POLICY</strong></h3>

                    <p>The Company reserves the right to change this policy and our Terms of Service at any time.&nbsp; We will notify you of significant changes to our Privacy Policy by sending a notice to the primary email address specified in your account or by placing a prominent notice on our site.&nbsp; Significant changes will go into effect 30 days following such notification.&nbsp; Non-material changes or clarifications will take effect immediately. You should periodically check the Site and this privacy page for updates.</p>

                    <hr />
                    <h3><strong>VII.CONTACT US</strong></h3>

                    <p>If you have any questions regarding this Privacy Policy or the practices of this Site, please contact us by sending an email to&nbsp;<a href="http://freezylist.lusites.xyz/">freezylist.lusites.xyz</a>.</p>

                    <p>Last Updated: This Privacy Policy was last updated on June 1, 2016</p>

                    <p>&nbsp;</p>',
                'created_at' => '2018-09-07 12:44:23',
            ],
            [
                'title' => 'Term of Use & Limited Liability',
                'slug' => 'term-of-use-&-limited-liability',
                'content' => '<h3><strong>NARWHAL REALTY, INC. [OPERATING AS FREEZYLIST.COM]&nbsp;(THE &quot;COMPANY&quot;)&nbsp;TERMS OF USE</strong></h3>

                        <hr />
                        <h3><strong>(Effective as of 15-March-2016)</strong></h3>

                        <p>Welcome to Freezylist.com (the &ldquo;Service&rdquo;). &nbsp;The following Terms of Use apply when you view or use the Service via our website located at&nbsp;<a href="http://freezylist.lusites.xyz/">freezylist.lusites.xyz</a>&nbsp; Please review the following terms carefully. &nbsp;By accessing or using the Service, you signify your agreement to these Terms of Use. &nbsp;If you do not agree to these Terms of Use, you may not access or use the Service.</p>

                        <h3><strong>PRIVACY POLICY</strong></h3>

                        <p>The Company respects the privacy of its Service users. &nbsp;Please refer to the Company&rsquo;s Privacy Policy (found here:&nbsp;<a href="http://freezylist.lusites.xyz/privacy">freezylist.lusites.xyz/privacy</a>which explains how we collect, use, and disclose information that pertains to your privacy. &nbsp;When you access or use the Service, you signify your agreement to this Privacy Policy.</p>

                        <hr />
                        <h3><strong>ABOUT THE SERVICE</strong></h3>

                        <p>The Service offers the features (including, but not limited to):</p>

                        <p>Create a unique user login ID and Account (Either Personal or Business).</p>

                        <p>Search, View and List Properties including but not limited to for Sale, Rent, Timeshare Rental &amp; Exchange, and Vacation Rentals.</p>

                        <p>View blog and forum information, as well as post comments and create your own forum topics.</p>

                        <p>View supporting information pages (Information, Help, About Us, Etc.).</p>

                        <p>&nbsp;Contact and/or chat with Freezylist.com for general questions/comments/help, etc. at&nbsp;<a href="http://freezylist.lusites.xyz/contact">freezylist.lusites.xyz/contact</a></p>

                        <p>Maintain a scheduling calendar and schedule viewing sessions with other users.</p>

                        <p>Create a social network by searching other users, requesting a social connection, and communicate directly to other users at&nbsp;<a href="http://freezylist.lusites.xyz/social-network">freezylist.lusites.xyz/social-search</a></p>

                        <p>Contact and/or transact with service providers to support your closing process.</p>

                        <p>Download contract templates, strictly for personal use, at your own risk.</p>

                        <p>Create a personal Profile and manage your properties, network offers, documents, etc.</p>

                        <p>Contact/Make tentative offers on For Sale or For Rent properties directly to the listing users.</p>

                        <p>Negotiate (Accept/Reject/Counter) the terms of received tentative offers on your listed properties securely between two users.</p>

                        <p>Enter into our proprietary contract tools solution, which facilitates the preparation of the contracts through direct questions, fetch queries which consolidate your previously submitted information on the property and your user account, and prepares the documents for your review.</p>

                        <p>Associate with Co-Signing users (each having a separate unique login ID and Account) to Co-Sign your contracts.</p>

                        <p>Allow Buyers/Sellers &amp; Tenants/Landlords to enter into legally binding agreements through automated contract preparation flows and secured signature processes.</p>

                        <p>Digitally Sign documents, specific to your own user Login ID.</p>

                        <p>Purchase signed documents for execution of the sale/lease agreement.</p>

                        <p>Contact the listing user for vacation rental/timeshare property listings.</p>

                        <p>Manage the calendar of availability of your vacation rental/timeshare.</p>

                        <p>Control your privacy settings on your account.</p>

                        <hr />
                        <h3><strong>REGISTRATION; RULES FOR USER CONDUCT AND USE OF THE SERVICE</strong></h3>

                        <p>You need to be at least 16 years old and a resident of the United States to register for and use the Service.</p>

                        <p>If you are a user who signs up for the Service, will create a personalized account which includes a unique username and a password to access the Service and to receive messages from the Company- &nbsp;You agree to notify us immediately of any unauthorized use of your password and/or account. The Company will not be responsible for any liabilities, losses, or damages arising out of the unauthorized use of your member name, password and/or account.</p>

                        <hr />
                        <h3><strong>USE RESTRICTIONS</strong></h3>

                        <p>Your permission to use the Site is conditioned upon the following Use Restrictions and Conduct Restrictions: You agree that you will not under any circumstances:</p>

                        <p>&nbsp;post any information that is abusive, threatening, obscene, defamatory, libelous, or racially, sexually, religiously, or otherwise objectionable and offensive;</p>

                        <p>use the service for any unlawful purpose or for the promotion of illegal activities;</p>

                        <p>attempt to / or harass, abuse or harm another person or group;</p>

                        <p>use another user&rsquo;s account without permission;</p>

                        <p>provide false or inaccurate information when registering an account;</p>

                        <p>&nbsp;interfere or attempt to interfere with the proper functioning of the Service;</p>

                        <p>make any automated use of the system, or take any action that we deem to impose or to potentially impose an unreasonable or disproportionately large load on our servers or network infrastructure;</p>

                        <p>bypass any robot exclusion headers or other measures we take to restrict access to the Service or use any software, technology, or device to scrape, spider, or crawl the Service or harvest or manipulate data; or</p>

                        <p>publish or link to malicious content intended to damage or disrupt another user&rsquo;s browser or computer.</p>

                        <hr />
                        <h3><strong>POSTING AND CONDUCT RESTRICTIONS</strong></h3>

                        <p>When you create your own personalized account, you may be able to provide (&ldquo;User Content&rdquo;). &nbsp;You are solely responsible for the User Content that you post, upload, link to or otherwise make available via the Service. &nbsp;You agree that we are only acting as a passive conduit for your online distribution and publication of your User Content. &nbsp;The Company, however, reserves the right to remove any User Content from the Service at its discretion.</p>

                        <p>The following rules pertain to User Content. By transmitting and submitting any User Content while using the Service, you agree as follows:</p>

                        <p>You are solely responsible for your account and the activity that occurs while signed in to or while using your account;</p>

                        <p>You will not post information that is malicious, false or inaccurate;</p>

                        <p>You will not submit content that is copyrighted or subject to third party proprietary rights, including privacy, publicity, trade secret, etc., unless you are the owner of such rights or have the appropriate permission from their rightful owner to specifically submit such content; and</p>

                        <p>You hereby affirm we have the right to determine whether any of your User Content submissions are appropriate and comply with these Terms of Service, remove any and/or all of your submissions, and terminate your account with or without prior notice.</p>

                        <p>You understand and agree that any liability, loss or damage that occurs as a result of the use of any User Content that you make available or access through your use of the Service is solely your responsibility. &nbsp;The Company is not responsible for any public display or misuse of your User Content. &nbsp;The Company does not, and cannot, pre-screen or monitor all User Content. &nbsp;However, at our discretion, we, or technology we employ, may monitor and/or record your interactions with the Service.</p>

                        <hr />
                        <h3><strong>ONLINE CONTENT DISCLAIMER</strong></h3>

                        <p>Opinions, advice, statements, offers, or other information or content made available through the Service, but not directly by the Company, are those of their respective authors, and should not necessarily be relied upon. &nbsp;Such authors are solely responsible for such content. &nbsp;The Company does not guarantee the accuracy, completeness, or usefulness of any information on the Service and neither does the Company adopt nor endorse, nor is the Company responsible for, the accuracy or reliability of any opinion, advice, or statement made by parties other than the Company. &nbsp;The Company takes no responsibility and assumes no liability for any User Content that you or any other user or third party posts or sends over the Service. &nbsp;Under no circumstances will the Company be responsible for any loss or damage resulting from anyone&rsquo;s reliance on information or other content posted on the Service, or transmitted to users.</p>

                        <p>Though the Company strives to enforce these Terms of Use, you may be exposed to User Content that is inaccurate or objectionable. &nbsp;The Company reserves the right, but has no obligation, to monitor the materials posted in the public areas of the service or to limit or deny a user&rsquo;s access to the Service or take other appropriate action if a user violates these Terms of Use or engages in any activity that violates the rights of any person or entity or which we deem unlawful, offensive, abusive, harmful or malicious. &nbsp;E-mails sent between you and other participants that are not readily accessible to the general public will be treated by us as private to the extent required by applicable law. &nbsp;The Company shall have the right to remove any such material that in its sole opinion violates, or is alleged to violate, the law or this agreement or which might be offensive, or that might violate the rights, harm, or threaten the safety of users or others. &nbsp;Unauthorized use may result in criminal and/or civil prosecution under Federal, State and local law. &nbsp;If you become aware of misuse of our Service, please contact us&nbsp;info@freezylist.com.</p>

                        <hr />
                        <h3><strong>LINKS TO OTHER SITES AND/OR MATERIALS</strong></h3>

                        <p>As part of the Service, the Company may provide you with convenient links to third party website(s) (&ldquo;Third Party Sites&rdquo;) as well as content or items belonging to or originating from third parties (the &ldquo;Third Party Applications, Software or Content&rdquo;). &nbsp;These links are provided as a courtesy to Service subscribers. &nbsp;The Company has no control over Third Party Sites and Third Party Applications, Software or Content or the promotions, materials, information, goods or services available on these Third Party Sites or Third Party Applications, Software or Content. &nbsp;Such Third Party Sites and Third Party Applications, Software or Content are not investigated, monitored or checked for accuracy, appropriateness, or completeness by the Company, and the Company is not responsible for any Third Party Sites accessed through the Site or any Third Party Applications, Software or Content posted on, available through or installed from the Site, including the content, accuracy, offensiveness, opinions, reliability, privacy practices or other policies of or contained in the Third Party Sites or the Third Party Applications, Software or Content. &nbsp;Inclusion of, linking to or permitting the use or installation of any Third Party Site or any Third Party Applications, Software or Content does not imply approval or endorsement thereof by the Company. &nbsp;If you decide to leave the Site and access the Third Party Sites or to use or install any Third Party Applications, Software or Content, you do so at your own risk and you should be aware that our terms and policies no longer govern. &nbsp;You should review the applicable terms and policies, including privacy and data gathering practices, of any site to which you navigate from the Site or relating to any applications you use or install from the site.</p>

                        <hr />
                        <h3><strong>COPYRIGHT COMPLAINTS AND COPYRIGHT AGENT</strong></h3>

                        <p><strong>(a) Termination of Repeat Infringer Accounts</strong>. &nbsp;The Company respects the intellectual property rights of others and requests that the users do the same. &nbsp;Pursuant to 17 U.S.C. 512(i) of the United States Copyright Act, the Company has adopted and implemented a policy that provides for the termination in appropriate circumstances of users of the Service who are repeat infringers. &nbsp;The Company may terminate access for participants or users who are found repeatedly to provide or post protected third party content without necessary rights and permissions.</p>

                        <p><strong>(b) DMCA Take-Down Notices</strong>. &nbsp;If you are a copyright owner or an agent thereof and believe, in good faith, that any materials provided on the Service infringe upon your copyrights, you may submit a notification pursuant to the Digital Millennium Copyright Act (<em>see</em>&nbsp;17 U.S.C 512) (&ldquo;DMCA&rdquo;) by sending the following information in writing to the Company&rsquo;s designated copyright agent at&nbsp;Registered Agents Inc. Attn: Narwhal Realty, Inc. 8 The Green, Ste A Dover, DE 19901</p>

                        <p>The date of your notification;</p>

                        <p>A physical or electronic signature of a person authorized to act on behalf of the owner of an exclusive right that is allegedly infringed;</p>

                        <p>A description of the copyrighted work claimed to have been infringed, or, if multiple copyrighted works at a single online site are covered by a single notification, a representative list of such works at that site;</p>

                        <p>A description of the material that is claimed to be infringing or to be the subject of infringing activity and information sufficient to enable us to locate such work;</p>

                        <p>Information reasonably sufficient to permit the service provider to contact you, such as an address, telephone number, and/or email address;</p>

                        <p>A statement that you have a good faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent, or the law; and</p>

                        <p>A statement that the information in the notification is accurate, and under penalty of perjury, that you are authorized to act on behalf of the owner of an exclusive right that is allegedly infringed.</p>

                        <p><strong>(c) Counter-Notices</strong>. If you believe that your User Content that has been removed from the Site is not infringing, or that you have the authorization from the copyright owner, the copyright owner&#39;s agent, or pursuant to the law, to post and use the content in your User Content, you may send a counter-notice containing the following information to our copyright agent using the contact information set forth above:</p>

                        <p>Your physical or electronic signature;</p>

                        <p>A description of the content that has been removed and the location at which the content appeared before it was removed;</p>

                        <p>A statement that you have a good faith belief that the content was removed as a result of mistake or a misidentification of the content; and</p>

                        <p>Your name, address, telephone number, and email address, a statement that you consent to the jurisdiction of the federal court in New York and a statement that you will accept service of process from the person who provided notification of the alleged infringement.</p>

                        <p>If a counter-notice is received by the Company copyright agent, the Company may send a copy of the counter-notice to the original complaining party informing such person that it may reinstate the removed content in 10 business days. &nbsp;Unless the copyright owner files an action seeking a court order against the content provider, member or user, the removed content may (in the Company&rsquo;s discretion) be reinstated on the Site in 10 to 14 business days or more after receipt of the counter-notice.</p>

                        <hr />
                        <h3><strong>LICENSE GRANT</strong></h3>

                        <p>By posting any User Content via the Service, you expressly grant, and you represent and warrant that you have a right to grant, to the Company a royalty-free, sub-licensable, transferable, perpetual, irrevocable, non-exclusive, worldwide license to use, reproduce, modify, publish, list information regarding, edit, translate, distribute, publicly perform, publicly display, and make derivative works of all such User Content and your name, voice, and/or likeness as contained in your User Content, if applicable, in whole or in part, and in any form, media or technology, whether now known or hereafter developed, for use in connection with the Service.</p>

                        <hr />
                        <h3><strong>INTELLECTUAL PROPERTY</strong></h3>

                        <p>You acknowledge and agree that we and our licensors retain ownership of all intellectual property rights of any kind related to the Service, including applicable copyrights, trademarks and other proprietary rights. &nbsp;Other product and company names that are mentioned on the Service may be trademarks of their respective owners. We reserve all rights that are not expressly granted to you under this Agreement.</p>

                        <hr />
                        <h3><strong>EMAIL MAY NOT BE USED TO PROVIDE NOTICE</strong></h3>

                        <p>Communications made through the Service&rsquo;s e-mail and messaging system, will not constitute legal notice to the Company or any of its officers, employees, agents or representatives in any situation where notice to the Company is required by contract or any law or regulation.</p>

                        <hr />
                        <h3><strong>USER CONSENT TO RECEIVE COMMUNICATIONS IN ELECTRONIC FORM</strong></h3>

                        <p>For contractual purposes, you (a) consent to receive communications from the Company in an electronic form via the email address you have submitted; and (b) agree that all Terms of Use, agreements, notices, disclosures, and other communications that the Company provides to you electronically satisfy any legal requirement that such communications would satisfy if it were in writing.&nbsp; The foregoing does not affect your non-waivable rights.</p>

                        <p>We may also use your email address, to send you other messages, including information about the Company and special offers. You may opt out of such email by changing your account settings or sending an email to&nbsp;info@freezylist.com&nbsp;or mail to the following postal address: Registered Agents Inc. Attn: Narwhal Realty, Inc. 8 The Green, Ste A&nbsp;Dover, DE 19901</p>

                        <p>Opting out may prevent you from receiving messages regarding the Company or special offers.</p>

                        <hr />
                        <h3><strong>WARRANTY DISCLAIMER</strong></h3>

                        <p>THE SERVICE, IS PROVIDED &ldquo;AS IS,&rdquo; WITHOUT WARRANTY OF ANY KIND. WITHOUT LIMITING THE FOREGOING, THE COMPANY EXPRESSLY DISCLAIMS ALL WARRANTIES, WHETHER EXPRESS, IMPLIED OR STATUTORY, REGARDING THE SERVICE INCLUDING WITHOUT LIMITATION ANY WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE, SECURITY, ACCURACY AND NON-INFRINGEMENT. WITHOUT LIMITING THE FOREGOING, THE COMPANY MAKES NO WARRANTY OR REPRESENTATION THAT ACCESS TO OR OPERATION OF THE SERVICE WILL BE UNINTERRUPTED OR ERROR FREE. YOU ASSUME FULL RESPONSIBILITY AND RISK OF LOSS RESULTING FROM YOUR DOWNLOADING AND/OR USE OF FILES, INFORMATION, CONTENT OR OTHER MATERIAL OBTAINED FROM THE SERVICE. SOME JURISDICTIONS LIMIT OR DO NOT PERMIT DISCLAIMERS OF WARRANTY, SO THIS PROVISION MAY NOT APPLY TO YOU.</p>

                        <hr />
                        <h3><strong>LIMITATION OF DAMAGES; RELEASE</strong></h3>

                        <p>TO THE EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT SHALL THE COMPANY, ITS AFFILIATES, DIRECTORS, OR EMPLOYEES, OR ITS LICENSORS OR PARTNERS, BE LIABLE TO YOU FOR ANY LOSS OF PROFITS, USE, &nbsp;OR DATA, OR FOR ANY INCIDENTAL, INDIRECT, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES, HOWEVER ARISING, THAT RESULT FROM (A) THE USE, DISCLOSURE, OR DISPLAY OF YOUR USER CONTENT; (B) YOUR USE OR INABILITY TO USE THE SERVICE; (C) THE SERVICE GENERALLY OR THE SOFTWARE OR SYSTEMS THAT MAKE THE SERVICE AVAILABLE; OR (D) ANY OTHER INTERACTIONS WITH THE COMPANY OR ANY OTHER USER OF THE SERVICE, WHETHER BASED ON WARRANTY, CONTRACT, TORT (INCLUDING NEGLIGENCE) OR ANY OTHER LEGAL THEORY, AND WHETHER OR NOT THE COMPANY HAS BEEN INFORMED OF THE POSSIBILITY OF SUCH DAMAGE, AND EVEN IF A REMEDY SET FORTH HEREIN IS FOUND TO HAVE FAILED OF ITS ESSENTIAL PURPOSE. &nbsp;SOME JURISDICTIONS LIMIT OR DO NOT PERMIT DISCLAIMERS OF LIABILITY, SO THIS PROVISION MAY NOT APPLY TO YOU.</p>

                        <p>If you have a dispute with one or more users, a restaurant or a merchant of a product or service that you review using the Service, you release us (and our officers, directors, agents, subsidiaries, joint ventures and employees) from claims, demands and damages (actual and consequential) of every kind and nature, known and unknown, arising out of or in any way connected with such disputes. &nbsp;If you are a California resident, you waive California Civil Code &sect;1542, which says: &ldquo;A general release does not extend to claims which the creditor does not know or suspect to exist in his favor at the time of executing the release, which if known by him must have materially affected his settlement with the debtor.&rdquo;</p>

                        <hr />
                        <h3><strong>MODIFICATION OF TERMS OF USE</strong></h3>

                        <p>We can amend these Terms of Use at any time and will update these Terms of Use in the event of any such amendments. &nbsp;It is your sole responsibility to check the Site from time to time to view any such changes in the Agreement. &nbsp;If you continue to use the Site, you signify your agreement to our revisions to these Terms of Use. &nbsp;However, we will notify you of material chances to the terms by posting a notice on our homepage and/or sending an email to the email address you provided to us upon registration. &nbsp;For this additional reason, you should keep your contact and profile information current. &nbsp;Any changes to these Terms (other than as set forth in this paragraph) or waiver of the Company&rsquo;s rights hereunder shall not be valid or effective except in a written agreement bearing the physical signature of an officer of the Company. &nbsp;No purported waiver or modification of this Agreement by the Company via telephonic or email communications shall be valid.</p>

                        <hr />
                        <h3><strong>GENERAL TERMS</strong></h3>

                        <p>If any part of this Agreement is held invalid or unenforceable, that portion of the Agreement will be construed consistent with applicable law. &nbsp;The remaining portions will remain in full force and effect. Any failure on the part of the Company to enforce any provision of this Agreement will not be considered a waiver of our right to enforce such provision. &nbsp;Our rights under this Agreement will survive any termination of this Agreement.</p>

                        <p>You agree that any cause of action related to or arising out of your relationship with the Company must commence within ONE year after the cause of action accrues. &nbsp;Otherwise, such cause of action is permanently barred.</p>

                        <p>These Terms of Use and your use of the Site are governed by the federal laws of the United States of America and the laws of the State of Delaware, without regard to conflict of law provisions.</p>

                        <p>The Company may assign or delegate these Terms of Service and/or the Company&rsquo;s Privacy Policy, in whole or in part, to any person or entity at any time with or without your consent. You may not assign or delegate any rights or obligations under the Terms of Service or Privacy Policy without the Company&rsquo;s prior written consent, and any unauthorized assignment and delegation by you is void.</p>

                        <p>YOU ACKNOWLEDGE THAT YOU HAVE READ THESE TERMS OF USE, UNDERSTAND THE TERMS OF USE, AND WILL BE BOUND BY THESE TERMS AND CONDITIONS. YOU FURTHER ACKNOWLEDGE THAT THESE TERMS OF USE TOGETHER WITH THE PRIVACY POLICY AT&nbsp;<a href="http://freezylist.lusites.xyz/privacy">freezylist.lusites.xyz/privacy</a>&nbsp;REPRESENT THE COMPLETE AND EXCLUSIVE STATEMENT OF THE AGREEMENT BETWEEN US AND THAT IT SUPERSEDES ANY PROPOSAL OR PRIOR AGREEMENT ORAL OR WRITTEN, AND ANY OTHER COMMUNICATIONS BETWEEN US RELATING TO THE SUBJECT MATTER OF THIS AGREEMENT.</p>

                        <hr />
                        <p>&nbsp;</p>

                        <h2><strong>&quot;CONTRACT SERVICES&quot; LIMITED LICENSE AGREEMENT AND LIMITED WARRANTY</strong></h2>

                        <h3><strong>IMPORTANT INFORMATION</strong></h3>

                        <p>This agreement governs your use of Narwhal Realty, Inc.&#39;s&nbsp;[Operating as Freezylist.com]&nbsp;(the &ldquo;Company&quot;)&nbsp;<em><strong>online contract preparation product</strong></em>&nbsp;(including its related user instructions and content) and&nbsp;<em><strong>digital signature application process</strong></em>&nbsp;(collectively, the &quot;Contract Services&quot;).</p>

                        <p>You may not use the Contract Services until you have read this agreement. By using the Contract Services, you indicate your unconditional acceptance of this agreement. If you do not accept this agreement, you must terminate your use of the Contract Services.</p>

                        <p>As used in this agreement, the terms &quot;you&quot;, &quot;your&quot; or &quot;user&quot; are synonymous, and refer to the person using the Contract Services in any way. A &quot;registered user&quot; is a user from whom the Company has received the information necessary to permit such person to prepare contracts or digitally sign prepared contracts using the Contract Services and who complies with the terms and conditions of this agreement.</p>

                        <hr />
                        <h3><strong>Permitted Uses and Restrictions on Use</strong></h3>

                        <p>Subject to this agreement, you are granted permission to use the Contract Services to prepare and digitally sign one set of real estate contracts and disclosures per applicable service fee paid and, after proper registration and any applicable payment, to print such documents. You may not use the Contract Services to prepare real estate contracts, disclosures or advice on a professional basis (i.e., for a fee for professional services) or on the behalf of any other user. Notwithstanding anything in this agreement, the company has no responsibility or liability for damages or claims relating to your unauthorized use of the Contract Services.</p>

                        <p>You may not copy, reproduce, republish, upload, post, transmit, or distribute any material from this site without the company&#39;s written permission. Modification or use of materials on the site for any purpose other than those permitted in this agreement is a violation of the company&#39;s copyright, trademark and trade secret rights.</p>

                        <p>You may not copy, print, scan, reproduce or otherwise export the documents or the information prepared for viewing and review during the contract services process. The rights to the contracts prepared and the information therein are restricted from personal use until (1) all parties to the contracts complete the document preparation and signing process and (2) the contracts are purchased through valid payment receipt by the company of the contract services application fee, without the express consent of the company. Upon payment receipt, the signed, official contracts will be made available to all parties of the contract and may be electronically stored or printed in paper form for authorized distribution to any relevant parties to the transaction (as the transaction is defined in the contract).</p>

                        <hr />
                        <h3><strong>User Responsibility</strong></h3>

                        <p>You agree to review your contracts and disclosures for inaccuracies and to correct the necessary information prior to digitally signing the documents. You are also responsible for acquiring and maintaining all equipment, computers, software and communications services (such as long distance phone charges) relating to the access and use of the Contract Services, and for all expenses relating thereto (plus applicable taxes). You must use your valid credit or charge card to pay all fees and charges related to the Contract Services and, except as otherwise provided herein, all fees and charges are non-refundable.</p>

                        <p>You acknowldge that your digital signature is valid and enforceable<strong><em>.&nbsp;</em></strong><strong><em>[***I</em></strong><em><strong>MPORTANT NOTICE!</strong></em>***&nbsp;Please review the E-Sign Disclosures at&nbsp;<a href="http://freezylist.lusites.xyz/e-sign-act-disclosure">freezylist.lusites.xyz/e-sign-act-disclosure</a></p>

                        <p>You acknowledge that the company is not qualified to provide legal services or guidance; any information disseminated or communication by the company is not to be construed as legal advice, guidance, or services. You further acknowledge that the company only assembles and compiles the information prepared by users to compile information into pre-defined contracts. The information provided by our users, and the contracts that are prepared by compiling this data does not constitute legal advice or Contract Services by the company and that the company encourages its users to seek licensed legal counsel.</p>

                        <hr />
                        <h3><strong>Security and Data Storage</strong></h3>

                        <p>You are the only person authorized to use your user identification and password, and you shall not permit or allow other persons to have access to or use the same. You are responsible for the use of the Contract Services under your user identification, and for maintaining the confidentiality of your user identification and password. Although the company has taken significant measures to ensure the security of information submitted by you when using the Contract Services, the company cannot guarantee the security of information collected during your use of the Contract Services and is not liable in any way for any compromise of your data. Except to the extent required by applicable law, the company has no obligation to store or maintain any information you provide to it, and you agree to print or save a copy of your documents for your records.</p>

                        <hr />
                        <h3><strong>Operation</strong></h3>

                        <p>The company has the right at any time and for any reason to modify or discontinue any aspect or feature of the Contract Services, including but not limited to its content, functionality or hours of availability, the equipment needed for its access or use, or its pricing. The company is not responsible for any damages due to such discontinuation of Contract Services. In addition, The company reserves the right, at any time, to change the terms of this agreement by publishing notice of such changes on its Internet site. Any use of the Contract Services by you after the company&#39;s publication of any such changes shall constitute your acceptance of this agreement as modified. You agree that the company is permitted to access and use any information provided by you to perform the Contract Services and, if necessary, to access such information to obtain contact information in order to provide notifications relating to the Contract Services to you.</p>

                        <hr />
                        <h3><strong>Satisfaction Guaranteed for Registered Users</strong></h3>

                        <p>If you are dissatisfied with the Contract Services prior to completing the billing steps within the program, your exclusive remedy is to immediately discontinue using the Contract Services.</p>

                        <hr />
                        <h3><strong>Limited Warranty for Registered Users</strong></h3>

                        <p>The company warrants the accuracy of its data compilation for registered users. If you are a registered user of the product and you find an error in the contract data due solely because of a data query error within the product and not as a result of, among other things, your failure to enter all required information accurately, your willful or fraudulent omission or inclusion of information, your misclassification of information, then the company will refund you&rsquo;re fees paid to the company for the transaction (offer id) of the error. If you believe such an error occurred and you have complied with the above conditions, please notify the company in writing at the address below as soon as you learn of the mistake. Registered Agents Inc.&nbsp;Attn: Narwhal Realty, Inc.&nbsp;8 The Green, Ste A&nbsp;Dover, DE 19901</p>

                        <p>You must include a copy of the applicable hardcopy documents, your user identification, Name and Address, and a notation of the error. Your filing of such a claim shall constitute your authorization for the company to obtain and review any data files that may be in the company&#39;s possession or control in order to evaluate your claim.</p>

                        <hr />
                        <h3><strong>DISCLAIMER OF WARRANTIES</strong></h3>

                        <p>EXCEPT AS EXPRESSLY PROVIDED ABOVE, THESE CONTRACT SERVICES ARE PROVIDED AS IS AND, TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, THE COMPANY AND ITS AGENTS, ASSIGNS, LICENSORS, DISTRIBUTORS, ADVERTISERS, WEB-LINK PROVIDERS, DEALERS OR SUPPLIERS (COLLECTIVELY, THE &quot;PARTICIPATING PARTIES&quot;) DISCLAIM ALL OTHER WARRANTIES, EXPRESS OR IMPLIED, REGARDING THE CONTRACT SERVICES AND THEIR RELATED MATERIALS, INCLUDING THEIR FITNESS FOR A PARTICULAR PURPOSE, THEIR QUALITY, THEIR MERCHANTABILITY, OR THEIR NON-INFRINGEMENT. THE COMPANY DOES NOT WARRANT THAT THE CONTRACT SERVICES ARE FREE FROM BUGS, INTERRUPTIONS, ERRORS, OR OTHER PROGRAM LIMITATIONS. THE COMPANY DOES NOT WARRANT THAT THIS SITE, OR THE SERVER THAT MAKES IT AVAILABLE, IS FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS. THE COMPANY DOES NOT WARRANT THAT THE CONTRACT SERVICES WILL BE AVAILABLE 24 HOURS PER DAY, SEVEN DAYS PER WEEK. YOU (AND NOT THE COMPANY) ASSUME THE ENTIRE COST OF ALL NECESSARY SERVICING, REPAIR, OR CORRECTION OF PROBLEMS CAUSED BY VIRUSES OR OTHER HARMFUL COMPONENTS. SOME STATES DO NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES, SO THE ABOVE EXCLUSIONS MAY NOT APPLY TO YOU. IN SUCH EVENT, ANY IMPLIED WARRANTIES ARE LIMITED IN DURATION TO 60 DAYS FROM THE DATE OF PURCHASE OF THE CONTRACT SERVICES. HOWEVER, SOME STATES DO NOT ALLOW LIMITATIONS ON HOW LONG AN IMPLIED WARRANTY LASTS, SO THE ABOVE LIMITATION MAY NOT APPLY TO YOU. THIS WARRANTY GIVES YOU SPECIFIC LEGAL RIGHTS, AND YOU MAY HAVE OTHER RIGHTS THAT VARY FROM STATE TO STATE. TAX LAWS AND REGULATIONS CHANGE FREQUENTLY AND THEIR APPLICATION CAN VARY WIDELY BASED UPON THE SPECIFIC FACTS AND CIRCUMSTANCES INVOLVED. USERS ARE RESPONSIBLE FOR CONSULTING WITH THEIR OWN PROFESSIONAL TAX ADVISORS CONCERNING THEIR SPECIFIC TAX CIRCUMSTANCES. THE COMPANY DISCLAIMS ANY RESPONSIBILITY FOR THE VALIDITY, ACCURACY, OR ADEQUACY OF ANY POSITIONS TAKEN BY USERS IN THEIR TAX RETURNS. All warranties or guarantees given or made by the company with respect to the Contract Services (1) are for the benefit of the Registered User of the Contract Services only and are not transferable, and (2) shall be null and void if you breach any terms or conditions of this agreement.</p>

                        <hr />
                        <h3><strong>Limitation of Liability and Damages</strong></h3>

                        <p>You acknowledge that the operation and availability of the communications systems used for accessing and interacting with the Contract Services (e.g., the public telephone, computer networks and the Internet) can be unpredictable and may, from time to time, interfere with or prevent access to Contract Services or their operation. The company is not in any way responsible for any such interference with or prevention of your use of or access to Contract Services.</p>

                        <p>Except to the extent of the limited warranty (for compilation accuracy) described above, the entire liability of The company and its Participating Parties for any reason shall be limited to the amount paid by you for the Contract Services licensed from The company. To the maximum extent permitted by applicable law, The company and its Participating Parties are not liable for any indirect, special, incidental, or consequential damages (including damages for loss of business, loss of profits or investment, or the like), whether based on breach of contract, breach of warranty, tort (including negligence), product liability or otherwise, even if The company or its Participating Parties have been advised of the possibility of such damages and even if a remedy set forth herein is found to have failed of its essential purpose. Some states do not allow the limitation and/or exclusion of liability for incidental or consequential damages, so the above limitation or exclusion may not apply to you.</p>

                        <p>The limitations of damages or liability set forth in this agreement are fundamental elements of the basis of the bargain between you and the company. You acknowledge and agree that the company would not be able to provide this product on an economic basis without such limitations.</p>

                        <hr />
                        <h3><strong>Miscellaneous</strong></h3>

                        <p>The company shall have the right to immediately terminate your access to or use of the Contract Services in the event of any activities which breach this agreement or conduct which, in the company&#39;s judgment, interferes with the operation or use of the Contract Services (e.g., excessive usage of the Contract Services which disrupts the use of the Contract Services by other users). Termination of this agreement automatically terminates your license and authorization to use the Contract Services and any content or other material contained therein.</p>

                        <p>This agreement (including any related content on the Contract Services, such as the introductory and welcome pages, which by this reference are incorporated herein) sets forth the company&#39;s and its Participating Parties&#39; entire liability and your exclusive remedy with respect to the Contract Services, and is a complete statement of the agreement between you and the company. This agreement does not limit any rights that the company may have under trade secret, trademark, copyright, patent or other laws. The employees of the company and its Participating Parties are not authorized to make modifications to this agreement, or to make any additional representations, commitments, or warranties binding on the company, except in a writing signed by an authorized officer of the company. If any provision of this agreement is invalid or unenforceable under applicable law, then it shall be, to that extent, deemed omitted and the remaining provisions will continue in full force and effect. The validity and performance of this agreement shall be governed by Delaware law (without reference to choice of law principles), and applicable federal law.</p>

                        <hr />
                        <h3><strong>Jurisdiction and Venue (Arbitration Clause)</strong></h3>

                        <p>Any dispute arising out of or relating to this contract, or the breach thereof, shall be finally resolved by arbitration, administered by the American Arbitration Association under its Commercial Arbitration Rules, and judgment upon the award rendered by the arbitrator(s) may be entered in any court having jurisdiction. The arbitration will be conducted in the English language in the city of Williamsburg, Virginia in accordance with the United States Arbitration Act. There shall be [up to] three arbitrator(s), named in accordance with such rules.</p>

                        <p>(a) If a dispute arises out of or relates to this contract, or the breach thereof, and if said dispute cannot be settled through negotiation, the parties agree first to try in good faith to settle the dispute by mediation under the Commercial Mediation Rules of the American Arbitration Association, before resorting to arbitration.</p>

                        <p>(b) Any dispute arising out of or relating to this contract, or the breach thereof, that cannot be resolved by mediation within 30 days shall be finally resolved by arbitration administered by the American Arbitration Association under its Commercial Arbitration Rules, and judgment upon the award rendered by the arbitrators may be entered in any court having jurisdiction. The arbitration will be conducted in the English language in the City of Williamsburg, Virginia, in accordance with the United States Arbitration Act. There shall be [up to] three arbitrator(s), named in accordance with such rules.&nbsp;The award of the arbitrator(s) shall be accompanied by a statement of the reasons upon which the award is based.</p>

                        <p>(c) The arbitrator(s) shall decide the dispute in accordance with the substantive law of the state of Delaware [state of incorporation].</p>',
                'created_at' => '2018-09-07 12:44:23',
            ],
            [
                'title' => 'E-Sign Act Disclosure',
                'slug' => 'e-sign-act-disclosure',
                'content' => '<h3><strong>E-SIGN ACT DISCLOSURE</strong></h3>

                        <p>The Electronic Signatures in Global and National Commerce Act (ESIGN, Pub.L. 106-229, 14 Stat. 464, enacted June 30, 2000, 15 U.S.C. ch.96) is a United States federal law passed by the U.S. Congress to facilitate the use of electronic records and signatures in interstate and foreign commerce by ensuring the validity and legal effect of contracts entered into electronically.</p>',
                'created_at' => '2018-09-07 12:44:23',
            ],
            [
                'title' => 'Corporate',
                'slug' => 'corporate',
                'content' => '<h3><strong>ON THE OTHER HAND</strong></h3>

                            <hr />
                            <p>we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is <em>untrammeled </em>and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures <strong><em>pains to avoid worse pains</em></strong>.&quot;</p>

                            <h3><br />
                            <img src="http://freezylist.lusites.xyz/storage/2018-09-14-08-20-26/mnzvq4HHNaNJIizFl1zGfEiW9y8WWPXaCLNl1rKC.jpeg" /></h3>',
                'created_at' => '2018-09-07 12:44:23',
            ],
        ]);
    }
}
