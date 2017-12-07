import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.web.support.SpringBootServletInitializer;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.ImportResource;

@Configuration
@EnableAutoConfiguration
@ComponentScan(basePackages = {"com.shixinke.farm"})
@ImportResource({"classpath:disconf.xml"})
@SpringBootApplication
/**
 * @author shixinke [ishixinke@qq.com]
 * @date 17-12-6.
 */
public class Application extends SpringBootServletInitializer {

    public static void main(String[] args) throws InterruptedException {
        SpringApplication.run(Application.class, args);
    }
}
