<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="text-right powered_by">
    Powered by <a href="http://wifincloud.com/">
        WiFinCloud
    </a>
</div>
</div>
</div>
<!--===============================================================================================-->
<script src="<?php echo $url->assets ?>front/js/popper.min.js"></script>
<script src="<?php echo $url->assets ?>front/js/bootstrap.min.js"></script>

<script src="<?php echo $url->assets ?>front/js/custom.js"></script>




<!-- Modal -->
<div class="modal fade" id="termsConditionsModal" tabindex="-1" aria-labelledby="tncModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tncModalLabel">Terms &amp; conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="terms_dialog">
	  
				<?php 
						$location_ids = (isset($_SESSION['location_id']))? $_SESSION['location_id'] : "";
						$location_ids = (isset( $location_id ))? $location_id : $location_ids;
						
						$location_terms = get_domain_meta( 'location_terms' , $location_ids ); 
						$domain_terms = get_domain_meta( 'domain_terms' ); 
						if(!empty($location_terms)){
							
							echo html_entity_decode(replace_regular_expression($location_terms));
						
						}else if(!empty($domain_terms)){
							
							echo html_entity_decode(replace_regular_expression($domain_terms));
						
						}else{
										?>
                    <p>This agreement sets out the terms and conditions on which wireless internet access (“the
                        Service”) is provided free of charge to you, a guest, vendor, board member or employee of the
                        Service Provider.</p>
                    <p>Your access to the Service is completely at the discretion of the Service Provider.&nbsp; Access to
                        the Service may be blocked, suspended, or terminated at any time for any reason including, but
                        not limited to, violation of this Agreement, actions that may lead to liability for the <?php echo ucfirst(str_replace("_" , " " , $_SESSION["domain_name"])); ?>, disruption of access to other users or networks, and violation of applicable laws or
                        regulations.&nbsp; The Service Provider reserves the right to monitor and collect information
                        while you are connected to the Service and that the collected information can be used at
                        discretion of the Service Provider, including sharing the information with any law enforcement
                        agencies, the Service Provider partners and/or the Service Provider vendors.</p>
                    <p>The Service Provider may revise this Agreement at any time. You must accept this Agreement each
                        time you use the Service and it is your responsibility to review it for any changes each time.
                    </p>
                    <p>We reserve the right at all times to withdraw the Service, change the specifications or manner of
                        use of the Service, to change access codes, usernames, passwords or other security information
                        necessary to access the service.</p>
                    <h5>IF YOU DO NOT AGREE WITH THESE TERMS, INCLUDING CHANGES THERETO, DO NOT ACCESS OR USE THE
                        SERVICE.</h5>
                    <ul>
                        <li>
                            <h6>1.&nbsp;Disclaimer</h6>
                            <p>You acknowledge</p>
                            <ol>
                                <li>that the Service may not be uninterrupted or error-free;</li>
                                <li>that your device may be exposed to viruses or other harmful applications&nbsp;
                                    through the Service;</li>
                                <li>that the Service Provider does not guarantee the security of the Service and that
                                    unauthorized third parties may access your computer or files or otherwise monitor
                                    your connection;</li>
                                <li>that the Service Provider’s ability to provide the Service without charge is based on
                                    the limited warranty, disclaimer and limitation of liability specified in this
                                    Section and it would require a substantial charge if any of these provisions were
                                    unenforceable;</li>
                                <li>that the Service Provider can at any point block access to Internet Services that they
                                    deem violate the acceptable terms of use outlined in 2.1.</li>
                            </ol>
                            <p>The service and any products or services provided on or in connection with the service
                                are provided on an "as is", "as available" basis without warranties of any kind. All
                                warranties, conditions, representations, indemnities and guarantees with respect to the
                                content or service and the operation, capacity, speed, functionality, qualifications, or
                                capabilities of the services, goods or personnel resources provided hereunder, whether
                                express or implied, arising by law, custom, prior oral or written statements by the
                                Service Provider, or otherwise (including, but not limited to any warranty of satisfactory
                                quality, merchantability, fitness for particular purpose, title and non-infringement)
                                are hereby overridden, excluded and disclaimed.</p>
                        </li>
                        <li>
                            <h6>2.&nbsp;Acceptable Use of the Service</h6>
                            <ul>
                                <li>2.1 &nbsp;You must not use the Service to access Internet Services, or send or
                                    receive e-mails, which:
                                    <ul>
                                        <li>2.1.1 &nbsp;are defamatory, threatening, intimidating or which could be
                                            classed as harassment;</li>
                                        <li>2.1.2 &nbsp;contain obscene, profane or abusive language or material;</li>
                                        <li>2.1.3 &nbsp;contain pornographic material (that is text, pictures, films,
                                            video clips of a sexually explicit or arousing nature);</li>
                                        <li>2.1.4 &nbsp;contain offensive or derogatory images regarding sex, race,
                                            religion, colour, origin, age, physical or mental disability, medical
                                            condition or sexual orientation;</li>
                                        <li>2.1.5 &nbsp;contain material which infringe third party’s rights (including
                                            intellectual property rights);</li>
                                        <li>2.1.6 &nbsp;in our reasonable opinion may adversely affect the manner in
                                            which we carry out our work;</li>
                                        <li>2.1.7 &nbsp;are bulk and/or commercial messages;</li>
                                        <li>2.1.8 &nbsp;contain forged or misrepresented message headers, whether in
                                            whole or in part, to mask the originator of the message;</li>
                                        <li>2.1.9 &nbsp;are activities that invade another’s privacy; or</li>
                                        <li>2.1.10 &nbsp;are otherwise unlawful or inappropriate;</li>
                                    </ul>
                                </li>
                                <li>2.2 &nbsp;Music, video, pictures, text and other content on the internet are
                                    copyright works and you should not download, alter, e-mail or otherwise use such
                                    content unless certain that the owner of such works has authorised its use by you.
                                </li>
                                <li>2.3 &nbsp;You must not use the service to access illegally or without authorization
                                    computers, accounts, equipment or networks belonging to another party, or attempting
                                    to penetrate security measures of another system. This includes any activity that
                                    may be used as a precursor to an attempted system penetration, including, but not
                                    limited to, port scans, stealth scans, or other information gathering activity.</li>
                                <li>2.4 &nbsp;You must not use the service to distribute Internet Viruses, Trojan
                                    Horses, or other destructive software.</li>
                                <li>2.5 &nbsp;The Service is intended for the Service Provider guest use only. Access to
                                    this Service must not be used for commercial activity.</li>
                                <li>2.6 &nbsp;We may terminate or temporarily suspend the Service if we reasonably
                                    believe that you are in breach of any provisions of this agreement including but not
                                    limited to clauses 2.1 to 2.5 above.</li>
                                <li>2.7 &nbsp;We recommend that you do not use the service to transmit or receive any
                                    confidential information or data and should you choose to do so you do so at your
                                    own risk.
                                    <br>&nbsp;
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h6>3.&nbsp;Criminal Activity</h6>
                            <ul>
                                <li>3.1 &nbsp;You must not use the Service to engage in any activity which constitutes
                                    or is capable of constituting a criminal offence, either in the United Arab Emirates
                                    or in any country throughout the world.</li>
                                <li>3.2 &nbsp;You agree and acknowledge that we may be required to provide assistance
                                    and information to law enforcement, governmental agencies and other authorities.
                                </li>
                                <li>3.3 &nbsp;You agree and acknowledge that we will monitor your activity while you use
                                    this service and keep a log of the Internet Protocol (“IP”) addresses of any devices
                                    which access the Service, the times when they have accessed the Service and the
                                    activity associated with that IP address</li>
                                <li>3.4 &nbsp;You further agree we are entitled to co-operate with law enforcement
                                    authorities and rights-holders in the investigation of any suspected or alleged
                                    illegal activity by you which may include, but is not limited to, disclosure of such
                                    information as we have (whether pursuant to clause 3.3 or otherwise), and are
                                    entitled to provide by law, to law enforcement authorities or rights-holders.
                                    <br>&nbsp;
                                </li>
                            </ul>
                        </li>
                        <li>
                            <h6>4.&nbsp;Other Terms</h6>
                            <ul>
                                <li>4.1 &nbsp;Under no circumstances will the Service Provider, their suppliers or
                                    licensors, or their respective officers, directors, employees, agents, and
                                    affiliates be liable for consequential, indirect, special, punitive or incidental
                                    damages, whether foreseeable or unforeseeable, based on claims of the Guest or its
                                    appointees (including, but not limited to, unauthorized access, damage, or theft of
                                    your system or data, claims for loss of goodwill, claims for loss of data, use of or
                                    reliance on the service, stoppage of other work or impairment of other assets, or
                                    damage caused to equipment or programs from any virus or other harmful application),
                                    arising out of breach or failure of express or implied warranty, breach of contract,
                                    misrepresentation, negligence, strict liability in tort or otherwise.</li>
                                <li>4.2 &nbsp;You agree to indemnify and hold harmless the Service Provider and its
                                    suppliers, licensors, officers, directors, employees, agents and affiliates from any
                                    claim, liability, loss, damage, cost, or expense (including without limitation
                                    reasonable attorney's fees) arising out of or related to your use of the Service,
                                    any materials downloaded or uploaded through the Service, any actions taken by you
                                    in connection with your use of the Service, any violation of any third party's
                                    rights or an violation of law or regulation, or any breach of this agreement. This
                                    Section will not be construed to limit or exclude any other claims or remedies that
                                    the Service Provider may assert under this Agreement or by law.</li>
                                <li>4.3 &nbsp;This Agreement shall not be construed as creating a partnership, joint
                                    venture, agency relationship or granting a franchise between the parties. Except as
                                    otherwise provided above, any waiver, amendment or other modification of this
                                    Agreement will not be effective unless in writing and signed by the party against
                                    whom enforcement is sought. If any provision of this Agreement is held to be
                                    unenforceable, in whole or in part, such holding will not affect the validity of the
                                    other provisions of this Agreement.</li>
                                <li>4.4 &nbsp;The Service Provider’ performance of this Agreement is subject to existing
                                    laws and legal process, and nothing contained in this Agreement shall waive or
                                    impede the Service Provider’ right to comply with law enforcement requests or
                                    requirements relating to your use of this Service or information provided to or
                                    gathered by the Service Provider with respect to such use. This Agreement constitutes
                                    the complete and entire statement of all terms, conditions and representations of
                                    the agreement between you and the Service Provider with respect to its subject matter
                                    and supersedes all prior writings or understanding.</li>
                            </ul>
                        </li>
                    </ul>
                    <p>By agreeing to the terms of service, I confirm that I accept these terms and conditions as the
                        basis of my use of the wireless internet access provided.</p>
						
						<?php 
						
							}
						?>
                </div>
      </div>
      
    </div>
  </div>
</div>
</body>

</html>