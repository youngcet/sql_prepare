<?php

	include ('db_handler.php');

	class SQLManager extends DBHandler
	{
		public function prepare ($query): bool
		{
			return $this->prepareStatement ($query);
		}

		public function execute ($values, $valueTypes): bool
		{
			return $this->executeStatement ($values, $valueTypes);
		}

		public function fetchRows(): array
		{
			return $this->fetchAll();
		}

		public function getErrorAsString(): string
		{
			return $this->getError()['error'];
		}

		public function close(): void
		{
			$this->closeConnection();
		}
	}

	$sql = new SQLManager;
	$Sqlresults = $sql->prepare (SELECT_RECORD);
	if (! $Sqlresults)
		die ($sql->getErrorAsString());

	$Sqlresults = $sql->execute ($params = array ($custId), 's');
	if (! $Sqlresults)
		die ($sql->getErrorAsString());

	$recordExist = $sql->fetchRows();
	if (is_array ($recordExist) && empty ($recordExist))
	{
		$Sqlresults = $sql->prepare (INSERT_RECORD);
		if (! $Sqlresults)
			die ($sql->getErrorAsString());

		$Sqlresults = $sql->execute ($params = array ($fiel1, $field2, $field3, $field4, $field5), 'ssssi');
		if (! $Sqlresults)
			die ($sql->getErrorAsString());
	}

	$sql->close();
?>