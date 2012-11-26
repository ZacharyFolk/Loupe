<?php //contextmenu event ?>
				
					<div class="rcmenu" style="display:none">
						<div id="handle">
							<div class="grabSpan"></div>
							<div class="rcClose">x</div>
						</div>
						
						<ul class="rcHeading">
							<li class="rcTitle"><?php the_title(); ?></li>
							<li>
							<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/80x15.png" /></a>
							</li>
						</ul>
						
						<ul id="rcControls">	
							<li class="rcZin"><span>[+] Zoom In</span></li>
							<li class="rcZout"><span>[-] Zoom Out</span></li>
							<li class="rcZ100"><span>[=] Fit Screen</span></li>				
						</ul>
						
						<ul id="rcNav">
							<li><span><?php previous_post_link(); ?> </span></li>
							<li class="rcSep"> | </li>
							</li><li><span><?php next_post_link(); ?> </span></li>
						</ul>
											
						<!-- // show subs //
							div class="first_li"><span>Preview</span>
							<div class="inner_li">
								<span>Channel 1</span>
								<span>Channel 2 </span>
							</div>
						</div-->
					</div>