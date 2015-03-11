<?php

/**
 * Task that creates subsite domains on dev environments
 * Handy when you want to test subdomains locally or on a test server
 * 
 * Uses the current domain as a base which results for mydomain.com:
 * * subsite1.mydomain.com
 * * subsite2.mydomain.com
 */
class CreateDevSubsiteDomainsTask extends BuildTask {

	protected $title          = "Create Development Subsite Domains";
	protected $description    = "Creates development domains for sub sites as sub domains of the current url";


	public function run($request) {
		
		//this will be used as the base for the created sub domains
		$domain = $_SERVER['HTTP_HOST'];

		echo "Domain: ";
		echo $domain . '<hr/>';
		
		echo "The following subsite domains have been set up: <br /><br />";
		$domains = SubsiteDomain::get();
		
		foreach ($domains as $d) {
			
			
			//we only want 1 domain per site
			//we'll accomplish that by checking for isPrimary
			if ($d->IsPrimary) {
				
				//we're taking the first part of the domain and adding
				//the current to it to create the new domain
				
				$dStrs = explode('.', $d->Domain);
				
				$newDomain = $dStrs[0] . '.' . $domain;
				
				echo $newDomain . '<br />';
				
				//checking if this domain already exists, to not create it twice
				$exists = SubsiteDomain::get()
					->filter('Domain', $newDomain)->first();
				if (!$exists) {
					$newDomainObj = new SubsiteDomain();
					$newDomainObj->Domain = $newDomain;
					$newDomainObj->SubsiteID = $d->SubsiteID;
					$newDomainObj->write();
				}
			}
			
		}
	}
}