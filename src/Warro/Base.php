<?php

/*
 *
 * Developed by Warro#7777
 * Join Ganja: ganja.bet:19132
 * My Discord: https://discord.gg/vasar
 * Repository: https://github.com/Wqrro/Ganja
 *
 */

declare(strict_types=1);

namespace Warro;

use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\data\bedrock\PotionTypeIdMap;
use pocketmine\data\bedrock\PotionTypeIds;
use pocketmine\data\SavedDataLoadingException;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\world\World;
use Warro\entities\VasarPotion;

class Base extends PluginBase
{

	public static Base $instance;

	public static function getInstance(): Base
	{
		return self::$instance;
	}

	public function onLoad(): void
	{
		self::$instance = $this;

		/*
		 *
		 * 1. Make sure you have DEVirion to be able to load Virions (view the link below)
		 * DEVirion by poggit: https://poggit.pmmp.io/p/DEVirion/1.2.8
		 *
		 * 2. Make sure you have libasynql in your Virions folder (view the link below)
		 * libasynql by poggit: https://poggit.pmmp.io/ci/poggit/libasynql/libasynql
		 *
		 * Open an issue on the repository or DM me on Discord at Warro#7777 if you have any questions
		 *
		 */

        EntityFactory::getInstance()->register(VasarPotion::class, function (World $world, CompoundTag $nbt): VasarPotion {
            $potionType = PotionTypeIdMap::getInstance()->fromId($nbt->getShort('PotionId', PotionTypeIds::WATER));
            if ($potionType === null) {
                throw new SavedDataLoadingException();
            }
            return new VasarPotion(EntityDataHelper::parseLocation($nbt, $world), null, $potionType, $nbt);

        }, ['ThrownPotion', 'minecraft:potion', 'thrownpotion'], EntityLegacyIds::SPLASH_POTION);
	}
}