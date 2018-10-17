
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `oc_btslider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oc_btslider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `oc_btslider` DISABLE KEYS */;
INSERT INTO `oc_btslider` VALUES (26,'{\"slider_type\":\"fullscreen\",\"slider_width\":\"1640\",\"slider_height\":\"750\",\"delay\":\"5000\",\"startWithSlide\":\"0\",\"stopslider\":\"on\",\"stopafterloops\":\"-1\",\"stopatslide\":\"-1\",\"touchenabled\":\"on\",\"onhoverstop\":\"on\",\"timeline\":\"on\",\"timerlineposition\":\"bottom\",\"shadow\":\"0\",\"navigationtype\":\"none\",\"navigationarrow\":\"solo\",\"navigationstyle\":\"square\",\"navigationhalign\":\"left\",\"navigationvalign\":\"top\",\"navigationhoffset\":\"0\",\"navigationvoffset\":\"0\",\"soloarrowlefthalign\":\"right\",\"soloarrowleftvalign\":\"bottom\",\"soloarrowlefthoffset\":\"85\",\"soloarrowleftvoffset\":\"30\",\"soloarrowrighthalign\":\"right\",\"soloarrowrightvalign\":\"bottom\",\"soloarrowrighthoffset\":\"30\",\"soloarrowrightvoffset\":\"30\",\"timehidethumbnail\":\"0\",\"thumbnailwidth\":\"0\",\"thumbnailheight\":\"0\",\"thumbamount\":\"0\",\"hidecapptionatlimit\":\"0\",\"hideallcapptionatlimit\":\"0\",\"hideslideratlimit\":\"0\"}');
/*!40000 ALTER TABLE `oc_btslider` ENABLE KEYS */;
DROP TABLE IF EXISTS `oc_btslider_slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oc_btslider_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `slideset` text,
  `caption` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40000 ALTER TABLE `oc_btslider_slide` DISABLE KEYS */;
INSERT INTO `oc_btslider_slide` VALUES (23,26,1,1,'{\"url\":\"#\",\"enablelink\":\"1\",\"type_background\":\"image_bg\",\"background\":\"catalog/bt_slide/slide-1.jpg\",\"transitions\":\"random\",\"slotamount\":\"7\",\"masterspeed\":\"500\",\"delay\":\"5000\",\"target\":\"_self\",\"kenburns\":\"off\",\"enablefullvideo\":\"0\"}','[{\"image_caption\":\"catalog\\/bt_slide\\/revo1-main-text-1.png\",\"datax\":\"655\",\"type_caption\":\"image\",\"datay\":\"260\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"500\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"sft\",\"outgo_animation\":\"stt\",\"easing\":\"easeOutBack\",\"endeasing\":\"easeOutBack\"},{\"image_caption\":\"catalog\\/bt_slide\\/revo1-main-text-2.png\",\"datax\":\"655\",\"type_caption\":\"image\",\"datay\":\"435\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"1000\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"sft\",\"outgo_animation\":\"stt\",\"easing\":\"easeOutBack\",\"endeasing\":\"easeOutBack\"},{\"image_caption\":\"catalog\\/bt_slide\\/revo1-main-text-3.png\",\"datax\":\"655\",\"type_caption\":\"image\",\"datay\":\"515\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"1500\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"sft\",\"outgo_animation\":\"stt\",\"easing\":\"easeOutBack\",\"endeasing\":\"easeOutBack\"}]'),(24,26,1,2,'{\"url\":\"#\",\"enablelink\":\"0\",\"type_background\":\"image_bg\",\"background\":\"catalog/bt_slide/slide-2.jpg\",\"transitions\":\"random\",\"slotamount\":\"7\",\"masterspeed\":\"500\",\"delay\":\"5000\",\"target\":\"_self\",\"kenburns\":\"off\",\"enablefullvideo\":\"0\"}','[{\"image_caption\":\"catalog\\/bt_slide\\/revo2-main-text-1.png\",\"datax\":\"620\",\"type_caption\":\"image\",\"datay\":\"310\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"500\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"sfb\",\"outgo_animation\":\"stb\",\"easing\":\"easeOutBack\",\"endeasing\":\"easeOutBack\"},{\"image_caption\":\"catalog\\/bt_slide\\/revo2-main-text-2.png\",\"datax\":\"720\",\"type_caption\":\"image\",\"datay\":\"435\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"1000\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"sfb\",\"outgo_animation\":\"stb\",\"easing\":\"easeOutQuad\",\"endeasing\":\"easeInOutQuad\"}]'),(25,26,1,3,'{\"url\":\"#\",\"enablelink\":\"0\",\"type_background\":\"image_bg\",\"background\":\"catalog/bt_slide/slide-3.jpg\",\"transitions\":\"random\",\"slotamount\":\"7\",\"masterspeed\":\"500\",\"delay\":\"5000\",\"target\":\"_self\",\"kenburns\":\"off\",\"enablefullvideo\":\"0\"}','[{\"image_caption\":\"catalog\\/bt_slide\\/revo3-main-text-1.png\",\"datax\":\"947\",\"type_caption\":\"image\",\"datay\":\"300\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"500\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"fade\",\"outgo_animation\":\"stt\",\"easing\":\"easeOutBack\",\"endeasing\":\"easeOutBack\"},{\"image_caption\":\"catalog\\/bt_slide\\/revo3-main-text-2.png\",\"datax\":\"1016\",\"type_caption\":\"image\",\"datay\":\"400\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"1000\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"fade\",\"outgo_animation\":\"stt\",\"easing\":\"easeOutBack\",\"endeasing\":\"easeOutBack\"},{\"image_caption\":\"catalog\\/bt_slide\\/revo3-main-text-3.png\",\"datax\":\"1080\",\"type_caption\":\"image\",\"datay\":\"485\",\"class_css\":\"big_white\",\"dataspeed\":\"500\",\"datastart\":\"1500\",\"dataend\":\"5500\",\"dataafterspeed\":\"500\",\"incom_animation\":\"fade\",\"outgo_animation\":\"stt\",\"easing\":\"easeOutBack\",\"endeasing\":\"easeOutBack\"}]');
/*!40000 ALTER TABLE `oc_btslider_slide` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

