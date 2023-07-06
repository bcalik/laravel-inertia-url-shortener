import {Box, Button, Center, createStyles, Group, Popover, Text, TextInput, Tooltip} from '@mantine/core';
import React, {useState, useEffect, useCallback} from 'react';
import Layout from '../../Layout';
import {InfoCircle} from "tabler-icons-react";
import {useForm} from "@mantine/form";
import {Inertia} from "@inertiajs/inertia";
import {Head, Link} from '@inertiajs/inertia-react';

const useStyles = createStyles((theme) => ({
  inputContainer: {
    maxWidth: '420px',
    margin: 'auto',
    "& > form > *": {
      marginTop: theme.spacing.md,
    },
  },
}));

function InputWithHelp({inputLabel, inputPlaceholder, tooltipLabel, ...props}) {
  const rightSection = (
    <Tooltip
      label={tooltipLabel} wrapLines width={300} placement="end" withArrow transition="pop-bottom-right"
    >
      <Text color="dimmed" sx={{cursor: 'help'}}>
        <Center>
          <InfoCircle size={18}/>
        </Center>
      </Text>
    </Tooltip>
  );

  return (
    <TextInput
      rightSection={rightSection} label={inputLabel} placeholder={inputPlaceholder}
      {...props}
    />
  );
}

const CreateLink = ({link, errors}) => {
  const {classes, cx} = useStyles();
  const [deletePopupOpened, setDeletePopupOpened] = useState(false);

  const form = useForm({
    initialValues: {
      slug: link?.slug || '',
      app_url: link?.app_url || '',
      android_url: link?.android_url || '',
      huawei_url: link?.huawei_url || '',
      ios_url: link?.ios_url || '',
      fallback_url: link?.fallback_url || '',
    },
    initialErrors: errors,
  });

  useEffect(() => {
    form.setErrors(errors);
  }, [errors]);

  const handleSubmit = useCallback((values) => {
    if (link?.id) {
      Inertia.post(`/app/links/edit/${link.id}`, values);
      return;
    }

    Inertia.post('/app/links/create', values);
  }, [link]);

  return (
    <Box className={classes.inputContainer}>
      <Head>
        <title>
          {link?.id
            ? "Edit Link"
            : "Create Link"
          }
        </title>
      </Head>

      <form onSubmit={form.onSubmit(handleSubmit)}>
        <InputWithHelp
          inputLabel="Link Slug" tooltipLabel="Leave empty to generate random slug."
          {...form.getInputProps('slug')}
        />
        <InputWithHelp
          inputLabel="App URL"
          inputPlaceholder="Ex: custom://..."
          tooltipLabel="You can set a custom url to open a deep link. It will be skipped if your app is not installed."
          {...form.getInputProps('app_url')}
        />
        <InputWithHelp
          inputLabel="Android URL"
          inputPlaceholder="Ex: https://play.google.com/store/apps/details?id=app.alternatif"
          tooltipLabel="Android users will be redirected to this url."
          {...form.getInputProps('android_url')}
        />
        <InputWithHelp
          inputLabel="Huawei URL"
          inputPlaceholder="Ex: https://appgallery.huawei.com/app/C104766455"
          tooltipLabel="Huawei users will be redirected to this url."
          {...form.getInputProps('huawei_url')}
        />
        <InputWithHelp
          inputLabel="iOS URL"
          inputPlaceholder="Ex: https://apps.apple.com/tr/app/alternatif-app/id1553747714?mt=8"
          tooltipLabel="iOS users will be redirected to this url."
          {...form.getInputProps('ios_url')}
        />
        <InputWithHelp
          inputLabel="Fallback URL"
          inputPlaceholder="Ex: https://alternatif.app"
          tooltipLabel="Rest of the users matching none of the above will be redirected to this url."
          {...form.getInputProps('fallback_url')}
        />

        <Group position="right" mt="md">
          {link?.id &&
            <Popover
              opened={deletePopupOpened}
              onClose={() => setDeletePopupOpened(false)}
              width={260}
              position="bottom"
              withArrow
            >
              <Popover.Target>
                <Button color="red" onClick={() => setDeletePopupOpened((o) => !o)}>Delete</Button>
              </Popover.Target>
              <Popover.Dropdown>
                <div style={{display: "flex"}}>
                  <Text size="sm">Are you sure you want to delete?</Text>
                  <Link href={`/app/links/delete/${link.id}`} method="delete">
                    <Button color="red" onClick={() => setDeletePopupOpened((o) => !o)}>Yes!</Button>
                  </Link>
                </div>
              </Popover.Dropdown>
            </Popover>
          }

          <Button type="submit">Submit</Button>
        </Group>
      </form>
    </Box>
  );
}

CreateLink.layout = page => {
  return !page.props.link
    ? <Layout children={page} title={"Create Link"}/>
    : <Layout children={page} title={"Edit Link"}/>;
}

export default CreateLink;
