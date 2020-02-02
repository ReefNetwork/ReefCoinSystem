<?php


namespace ree\sub\land;


use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class ReefLandAPI implements ReefLandAPI_Base
{
	/**
	 * @inheritDoc
	 */
	public static function addProtect(string $name, Vector3 $start, Vector3 $end, Level $level,string $id,int $maxHeight = 256, int $maxEntityCount = 3, bool $canUseSkill = true): bool
	{
		$name = mb_strtolower($name);
		$land = ReefLand::getDataBaseManager();
		$bb = new AxisAlignedBB($start->getFloorX() ,$start->getFloorY() ,$start->getFloorZ() ,$end->getFloorX() ,$end->getFloorY() ,$end->getFloorZ());
		foreach ($land->getAll() as $allId)
		{
			if (!$bb->intersectsWith($land->getPosition($allId)))
			{
				return false;
			}
		}
		return $land->setProtect($name ,$bb ,$level ,$id ,$start ,$maxHeight ,$maxEntityCount ,$canUseSkill);
	}

	/**
	 * @inheritDoc
	 */
	public static function isProtect(string $name, Vector3 $vec3, Level $level): bool
	{
		$name = mb_strtolower($name);
		$land = ReefLand::getDataBaseManager();
		foreach ($land->getAll() as $id)
		{
			if ($land->getPosition($id)->isVectorInside($vec3))
			{
				if (self::getProtectOwner($id) !== $name)
				{
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public static function getProtect(Vector3 $vec3 ,Level $level): ?string
	{
		$land = ReefLand::getDataBaseManager();
		return $land->getProtect($vec3 ,$level);
	}

	/**
	 * @inheritDoc
	 */
	public static function getProtectOwner(string $id): ?string
	{
		$land = ReefLand::getDataBaseManager();
		return $land->getOwner($id);
	}

	/**
	 * @inheritDoc
	 */
	public static function setProtectOwner(string $id, string $name): bool
	{
		$name = mb_strtolower($name);
		$land = ReefLand::getDataBaseManager();
		return $land->setOwner($id ,$name);
	}

	/**
	 * @inheritDoc
	 */
	public static function removeProtect(string $id): bool
	{
		$land = ReefLand::getDataBaseManager();
		return $land->removeProtect($id);
	}

	/**
	 * @inheritDoc
	 */
	public static function addShareProtect(string $id, string $name): bool
	{
		$name = mb_strtolower($name);
		$land = ReefLand::getDataBaseManager();
		$subUser = $land->getSpawnPoint($id);
		$users = explode(',' ,$subUser);
		if ($subUser === null or $name === self::getProtectOwner($id) or !in_array($name ,$users))
		{
			return false;
		}
		$users[] = $name;
		$subUser = implode(',' ,$users);
		return $land->setSubUsers($id ,$subUser);
	}

	/**
	 * @inheritDoc
	 */
	public static function removeShareProtect(string $id, string $name): bool
	{
		$name = mb_strtolower($name);
		$land = ReefLand::getDataBaseManager();
		$subUser = $land->getSpawnPoint($id);
		$users = explode(',' ,$subUser);
		if ($subUser === null or $name === self::getProtectOwner($id) or !in_array($name ,$users))
		{
			return false;
		}
		$result = array_values(array_diff($users ,[$name]));
		$subUser = implode(',' ,$result);
		return $land->setSubUsers($id ,$subUser);
	}

	/**
	 * @inheritDoc
	 */
	public static function getMaxEntityCount(string $id): ?string
	{
		$land = ReefLand::getDataBaseManager();
		return $land->getMaxEntityCount($id);
	}

	/**
	 * @inheritDoc
	 */
	public static function setMaxEntityCount(string $id ,$count): bool
	{
		$land = ReefLand::getDataBaseManager();
		return $land->setMaxEntityCount($id ,$count);
	}

	/**
	 * @inheritDoc
	 */
	public static function addEntityCount(string $id, int $count = 1): bool
	{
		if (self::getEntityCount($id) + $count > self::getMaxEntityCount($id))
		{
			return false;
		}
		return self::setEntityCount($id ,self::getEntityCount($id) + $count);
	}

	/**
	 * @inheritDoc
	 */
	public static function removeEntityCount(string $id, int $count = 1): bool
	{
		if (self::getEntityCount($id) - $count < 0)
		{
			return false;
		}
		return self::setEntityCount($id ,self::getEntityCount($id) - $count);
	}

	/**
	 * @inheritDoc
	 */
	public static function getEntityCount(string $id): ?int
	{
		$land = ReefLand::getDataBaseManager();
		return $land->getEntityCount($id);
	}

	/**
	 * @inheritDoc
	 */
	public static function setEntityCount(string $id, int $count): bool
	{
		$land = ReefLand::getDataBaseManager();
		return $land->setEntityCount($id ,$count);
	}

	/**
	 * @inheritDoc
	 */
	public static function getMaxHeight(string $id): ?int
	{
		$land = ReefLand::getDataBaseManager();
		return $land->getMaxHeight($id);
	}

	/**
	 * @inheritDoc
	 */
	public static function setMaxHeight(string $id, int $height): bool
	{
		$land = ReefLand::getDataBaseManager();
		return $land->setMaxHeight($id ,$height);
	}

	/**
	 * @inheritDoc
	 */
	public static function isCanUseSkill(string $id): bool
	{
		$land = ReefLand::getDataBaseManager();
		return $land->getUseSkill($id);
	}

	/**
	 * @inheritDoc
	 */
	public static function setCanUseSkill(string $id ,bool $bool): bool
	{
		$land = ReefLand::getDataBaseManager();
		return $land->setUseSkill($id ,$bool);
	}
}