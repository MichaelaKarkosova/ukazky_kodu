package com.lupe.deathcommands;

import java.io.File;
import java.io.IOException;
import java.util.List;
import java.util.Random;

import org.bukkit.Bukkit;
import org.bukkit.command.ConsoleCommandSender;
import org.bukkit.configuration.InvalidConfigurationException;
import org.bukkit.configuration.file.FileConfiguration;
import org.bukkit.configuration.file.YamlConfiguration;
import org.bukkit.entity.EntityType;
import org.bukkit.event.EventHandler;
import org.bukkit.event.Listener;
import org.bukkit.event.entity.PlayerDeathEvent;
import org.bukkit.event.player.PlayerRespawnEvent;
import org.bukkit.plugin.java.JavaPlugin;





public class main extends JavaPlugin implements Listener {
	public String prefix;
 public String cmsg;
    public String FinalCmd;
    public List<String> cmds;

	@Override
	public void onEnable() {

		  getServer().getPluginManager().registerEvents(this, this);
			String root1 = this.getDataFolder().getAbsolutePath();
			File file = new File(root1 + "/config.yml");
			if (!file.exists()) {
				System.out.println("Creating new config.yml...");
				this.saveDefaultConfig();
				prefix = getConfig().getString("Plugin.prefix");
			prefix = prefix.replace("&", "§");
	}
			else {
				prefix = getConfig().getString("Plugin.prefix");
			prefix = prefix.replace("&", "§");
			}
	}


	@EventHandler
	public void ondeath (PlayerDeathEvent event) {
		if (event.getEntityType() == EntityType.PLAYER)  {
			if (event.getEntity().getLastDamageCause().getCause() != null) {
			if (getConfig().getString("Causes."+event.getEntity().getLastDamageCause().getCause().toString().toLowerCase()+".execute_on").toString().equals("death")) {
				cmds = getConfig().getStringList("Causes."+event.getEntity().getLastDamageCause().getCause().toString().toLowerCase()+".commands");
				if (getConfig().getString("Causes."+event.getEntity().getLastDamageCause().getCause().toString().toLowerCase()+".random").toString().equals("false"))  {
					
					for (String c: cmds) {
						ConsoleCommandSender console = Bukkit.getServer().getConsoleSender();
						c = c.replace("%player%", event.getEntity().getName());
						c = c.replace("&", "§");
						Bukkit.dispatchCommand(console, c);
					}
				}
				else {
				  Random random = new Random();
			String randomcmd = cmds.get(random.nextInt(cmds.size()));
			ConsoleCommandSender console = Bukkit.getServer().getConsoleSender();
			randomcmd = randomcmd.replace("%player%", event.getEntity().getName());
			Bukkit.dispatchCommand(console, randomcmd);

			}
			}
		}
		}
	}
	@EventHandler
	public void onrespawn (PlayerRespawnEvent event) {
		if (event.getPlayer().getLastDamageCause().getCause() != null) {
			
			if (getConfig().getString("Causes."+event.getPlayer().getLastDamageCause().getCause().toString().toLowerCase()+".execute_on").toString().equals("respawn")) {
				cmds = getConfig().getStringList("Causes."+event.getPlayer().getLastDamageCause().getCause().toString().toLowerCase()+".commands");
				if (getConfig().getString("Causes."+event.getPlayer().getLastDamageCause().getCause().toString().toLowerCase()+".random").toString().equals("false"))  {
					for (String c: cmds) {
						ConsoleCommandSender console = Bukkit.getServer().getConsoleSender();
						c = c.replace("%player%", event.getPlayer().getName());
				    	 FinalCmd  = c;
						Bukkit.getServer().getScheduler().scheduleSyncDelayedTask(this, new Runnable() {
						     public void run() {
			
						Bukkit.dispatchCommand(console, FinalCmd);
						     }
						}, 1L); 
					}
				}
				else {
					System.out.println("random true");
				  Random random = new Random();
			String randomcmd = cmds.get(random.nextInt(cmds.size()));
			ConsoleCommandSender console = Bukkit.getServer().getConsoleSender();
			randomcmd = randomcmd.replace("%player%", event.getPlayer().getName());
			randomcmd = randomcmd.replace("&", "§");
			FinalCmd = randomcmd;
			Bukkit.getServer().getScheduler().scheduleSyncDelayedTask(this, new Runnable() {
			     public void run() {
			Bukkit.dispatchCommand(console, FinalCmd);
			     }
			}, 1L);
				}

			}
		}
	}
}
