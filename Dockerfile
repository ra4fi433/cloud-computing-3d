FROM ubuntu:latest

# Install cron
# RUN apt-get update && apt-get install -y cron curl nano
# RUN service cron start

RUN apt-get update && \
    apt-get install -y cron curl nano tzdata && \
    ln -fs /usr/share/zoneinfo/Asia/Jakarta /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

# Copy your script and cron file
COPY run-script.sh /usr/local/bin/run-script.sh
COPY my-crontab /etc/cron.d/my-crontab
COPY my-crontab /etc/crontab

# Give execution rights
RUN chmod +x /usr/local/bin/run-script.sh

# Apply cron job
RUN crontab /etc/cron.d/my-crontab

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Start cron
CMD ["cron", "-f"]
