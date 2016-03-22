<?php
/**
 *
 * This the the main class for dealing with the Architect Firm.
 *
 */

class ArchitectFirm
{
	private name;

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}
}

echo 'ArchitectFirm Class Here...';
?>
