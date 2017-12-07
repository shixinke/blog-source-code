package com.shixinke.farm.configuration;

import com.baidu.disconf.client.common.annotations.DisconfFile;
import com.baidu.disconf.client.common.annotations.DisconfFileItem;
import com.baidu.disconf.client.common.annotations.DisconfUpdateService;
import com.baidu.disconf.client.common.update.IDisconfUpdate;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.Scope;

@Configuration
@Scope("singleton")
@DisconfFile(filename = "business.properties")
@DisconfUpdateService(classes = {BusinessConfiguration.class})
/**
 * @author shixinke [ishixinke@qq.com]
 * @date 17-12-6.
 */
public class BusinessConfiguration implements IDisconfUpdate {

    private String appJsVersion;
    private String appCssVersion;

    @DisconfFileItem(name = "app.js.version", associateField = "appJsVersion")
    public String getAppJsVersion() {
        return appJsVersion;
    }

    public void setAppJsVersion(String appJsVersion) {
        this.appJsVersion = appJsVersion;
    }

    @DisconfFileItem(name = "app.css.version", associateField = "appCssVersion")
    public String getAppCssVersion() {
        return appCssVersion;
    }

    public void setAppCssVersion(String appCssVersion) {
        this.appCssVersion = appCssVersion;
    }

    /**
     * 这里为了简单，在此不添加任何第三方日志包(生产环境可使用其他log包)
     * @throws Exception
     */
    @Override
    public void reload() throws Exception {
        System.out.println("app.js.version:"+appJsVersion);
        System.out.println("app.css.version:"+appCssVersion);
    }

}
