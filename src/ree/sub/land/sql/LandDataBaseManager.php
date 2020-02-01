<?php


namespace ree\sub\land\sql;


use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use SQLite3;

class LandDataBaseManager implements LandDataBaseManager_Base
{
	/**
	 * @var SQLite3
	 */
	private $db;

	/**
	 * @inheritDoc
	 */
	public function __construct(string $pass)
	{
		$this->db = new SQLite3($pass);
		$this->setTable();
	}

	/**
	 * @inheritDoc
	 */
	public function isExists(string $id): bool
	{
		$stmt = $this->db->prepare('SELECT * FROM land VALUE :name WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		if (empty($stmt->execute()->fetchArray(SQLITE3_ASSOC)))
		{
			return false;
		}else{
			return true;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function getProtect(Vector3 $vec3, Level $level): ?string
	{
		$stmt = $this->db->prepare('SELECT id FROM land WHERE (sx <= :x ,sz <= :z ,ex >= :x ,ez >= :z ,level = :level)');
		$stmt->bindValue(':x', $vec3->getFloorX(), SQLITE3_INTEGER);
		$stmt->bindValue(':z', $vec3->getFloorZ(), SQLITE3_INTEGER);
		$stmt->bindParam(':level', $level->getName(), SQLITE3_TEXT);
		$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
		if (isset($result['id']))
		{
			return $result['id'];
		}else{
			return null;
		}

	}

	/**
	 * @inheritDoc
	 */
	public function setProtect(string $name, AxisAlignedBB $bb, Level $level, string $id, Vector3 $spawnPoint, int $maxHeight, int $maxEntityCount, bool $canUseSkill): bool
	{
		if ($this->isExists($id))
		{
			return false;
		}
		$subuser = '';
		$stmt = $this->db->prepare('REPLACE INTO land (id ,name ,sx ,sz ,ex ,ez ,level ,spx ,spy ,spz ,maxheight ,maxentity ,entity ,canskill ,subuser) VALUES (:id ,:name ,:sx ,:sz ,:ex ,:ez ,:land ,:spx ,:spy ,:spz ,:maxheight ,:maxentity ,:entity ,:canskill ,:subuser)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindParam(':name', $name, SQLITE3_TEXT);
		$stmt->bindValue(':sx', $bb->minX, SQLITE3_INTEGER);
		$stmt->bindValue(':sz', $bb->minZ, SQLITE3_INTEGER);
		$stmt->bindValue(':ex', $bb->maxX, SQLITE3_INTEGER);
		$stmt->bindValue(':ez', $bb->maxZ, SQLITE3_INTEGER);
		$stmt->bindParam(':level', $level->getName(), SQLITE3_TEXT);
		$stmt->bindValue(':spx', $spawnPoint->getFloorX(), SQLITE3_INTEGER);
		$stmt->bindValue(':spy', $spawnPoint->getFloorY(), SQLITE3_INTEGER);
		$stmt->bindValue(':spz', $spawnPoint->getFloorZ(), SQLITE3_INTEGER);
		$stmt->bindValue(':maxheight', $spawnPoint->getFloorX(), SQLITE3_INTEGER);
		$stmt->bindValue(':maxentity', $spawnPoint->getFloorY(), SQLITE3_INTEGER);
		$stmt->bindValue(':entity', $spawnPoint->getFloorZ(), SQLITE3_INTEGER);
		$stmt->bindParam(':canskill', $canUseSkill, SQLITE3_INTEGER);
		$stmt->bindParam(':subuser', $subuser, SQLITE3_INTEGER);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getOwner(string $id): ?string
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT name FROM land VALUE :name WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindParam(':name', $name, SQLITE3_TEXT);
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['name'];
	}

	/**
	 * @inheritDoc
	 */
	public function setOwner(string $id, string $name): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (name) VALUES (:name) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindParam(':name', $name, SQLITE3_TEXT);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getPosition(string $id): ?AxisAlignedBB
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT sx ,sz ,ex ,ez FROM land WHERE (id = :id)');
		$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
		$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
		return new AxisAlignedBB($result['sx'] ,1 ,$result['sz'] ,$result['ex'] ,1 ,$result['ez']);
	}

	/**
	 * @inheritDoc
	 */
	public function setPosition(string $id, AxisAlignedBB $bb): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (sx ,sz ,ex ,ez ) VALUES (:sx ,:sz ,:ex ,:ez ) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':sx', $bb->minX, SQLITE3_INTEGER);
		$stmt->bindValue(':sz', $bb->minZ, SQLITE3_INTEGER);
		$stmt->bindValue(':ex', $bb->maxX, SQLITE3_INTEGER);
		$stmt->bindValue(':ez', $bb->maxZ, SQLITE3_INTEGER);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getLevel(string $id): ?Level
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT level FROM land WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['land'];
	}

	/**
	 * @inheritDoc
	 */
	public function setLevel(string $id, Level $level): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (level ) VALUES (:level ) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindParam(':level', $level->getName(), SQLITE3_TEXT);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getMaxHeight(string $id): ?int
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT maxheight FROM land WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['maxheight'];
	}

	/**
	 * @inheritDoc
	 */
	public function setMaxHeight(string $id, int $height): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (maxheight ) VALUES (:maxheight) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':maxheight', $height, SQLITE3_INTEGER);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getMaxEntityCount(string $id): ?int
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT maxentity FROM land WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['maxentity'];
	}

	/**
	 * @inheritDoc
	 */
	public function setMaxEntityCount(string $id, int $count): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (maxentity ) VALUES (:maxentity) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':maxentity', $count, SQLITE3_INTEGER);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getEntityCount(string $id): ?int
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT entity FROM land WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['entity'];
	}

	/**
	 * @inheritDoc
	 */
	public function setEntityCount(string $id, int $count): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (entity ) VALUES (:entity) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':entity', $count, SQLITE3_INTEGER);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getUseSkill(string $id): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('SELECT canskill FROM land WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['canskill'];
	}

	/**
	 * @inheritDoc
	 */
	public function setUseSkill(string $id, bool $bool): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (canskill ) VALUES (:canskill) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindParam(':canskill', $bool , SQLITE3_BOTH);
		$stmt->execute();
	}

	/**
	 * @inheritDoc
	 */
	public function getSubUsers(string $id): ?string
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT subuser FROM land WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['subuser'];
	}

	/**
	 * @inheritDoc
	 */
	public function setSubUsers(string $id, string $users): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (subuser ) VALUES (:subuser) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindParam(':subuser', $users, SQLITE3_TEXT);
		$stmt->execute();
	}

	public function getSpawnPoint(string $id): ?Vector3
	{
		if (!$this->isExists($id))
		{
			return null;
		}
		$stmt = $this->db->prepare('SELECT spx ,spy ,spz FROM land WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
		return new Vector3($result['spx'] ,$result['spy'] ,$result['spz']);
	}

	public function setSpawnPoint(string $id, Vector3 $vec3): bool
	{
		if (!$this->isExists($id))
		{
			return false;
		}
		$stmt = $this->db->prepare('REPLACE INTO land (spx ,spy ,spz ) VALUES (:spx ,spy ,spz) WHERE (id = :id)');
		$stmt->bindParam(':id', $id, SQLITE3_TEXT);
		$stmt->bindValue(':spx', $vec3->getFloorX(), SQLITE3_INTEGER);
		$stmt->bindValue(':spy', $vec3->getFloorY(), SQLITE3_INTEGER);
		$stmt->bindValue(':spz', $vec3->getFloorZ(), SQLITE3_INTEGER);
		$stmt->execute();
	}

	private function setTable(): void
	{
		$this->db->exec('CREATE TABLE IF NOT EXISTS land (id TEXT NOT NULL ,name TEXT NOT NULL PRIMARY KEY ,sx NUMERIC NOT NULL ,sz NUMERIC NOT NULL ,ex NUMERIC NOT NULL ,ez NUMERIC NOT NULL ,level TEXT NOT NULL ,spx NUMERIC NOT NULL ,spy NUMERIC NOT NULL ,spz NUMERIC NOT NULL ,maxheight NUMERIC NOT NULL ,maxentity NUMERIC NOT NULL ,entity NUMERIC NOT NULL ,canskill BOTH NOT NULL ,subuser TEXT NOT NULL )');
	}
}